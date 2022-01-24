<?php

namespace App\Imports;

use App\Brand;
use App\Category;
use App\Product;
use App\Stock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StocksImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row['stockcode']) {
            if (!Stock::firstWhere('code', $row['stockcode'])) {
                if ($row['brand']) {
                    $brand = Brand::firstOrCreate([
                        'name' => $row['brand']
                    ]);
                }

                if ($row['category']) {
                    $category = Category::firstOrCreate([
                        'name' => $row['category']
                    ]);

                    if ($row['subcategory']) {
                        $subcategory = $category->subcategories()->firstOrCreate([
                            'name' => $row['subcategory']
                        ]);
                    }
                }

                $product = Product::firstOrCreate(
                    ['name' => $row['groupname'] ? $row['groupname'] : $row['name']],
                    [
                        'description'     => isset($row['description']) ? $row['description'] : null,
                        'brand_id'     => $row['brand'] ? $brand->id : null,
                        'category_id' => $row['category'] ? $category->id : null,
                        'subcategory_id' => $row['subcategory'] ? $subcategory->id : null,
                    ]
                );

                if ($row['groupphoto']) {
                    $product->photos()->firstOrCreate(
                        [
                            'path' => $row['groupphoto']
                        ],
                        [
                            'order' => 1
                        ]
                    );
                }

                $price = $row['old'] ? $row['old'] : ($row['price'] ? $row['price'] : 0);
                $price = $price / 1.06;

                $stock = Stock::create([
                    'name'     => $row['groupname'] ? $row['name'] : null,
                    'quantity'     => $row['available'] ? 10 : 0,
                    'price'     => $price,
                    'discount'     => (int) filter_var($row['percent'], FILTER_SANITIZE_NUMBER_INT),
                    'code'     => $row['stockcode'],
                    'product_id' => $product->id,
                    'thumbnail' => $row['colorphoto'] ? $row['colorphoto'] : null,
                ]);

                $stock->taxes()->attach(1);

                $stock->photos()->firstOrCreate(
                    [
                        'path' => $row['photo'],
                    ],
                    [
                        'product_id' => $product->id
                    ]
                );

                return $stock;
            }
        }
    }
}
