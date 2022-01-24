<?php

namespace App\Http\Controllers;

use App\Location;
use App\Product;
use App\Stock;
use GuzzleHttp\Client;

class SyncVC extends Controller
{
    private $client;

    public function __construct()
    {
        set_time_limit(0);

        $this->client = new Client([
            'base_uri' => 'http://deseomaldives.dyndns.org:44115',
        ]);
    }

    public function products()
    {
        $response = $this->client->request('GET','selby.json');

        $data = json_decode($response->getBody(), true);

        foreach ($data as $key=>$value){
            Product::updateOrCreate(
                ['code' => $key],
                ['description' => $value['d'], 'price' => $value['p']]
            );
        }
    }

    public function stocks(Location $location)
    {
        $response = $this->client->request('GET','stock.php?db='.$location->odbc);

        $data = json_decode($response->getBody(), true);

        foreach ($data as $key=>$value){
            $product = Product::firstWhere('code',$key);

            if ($product) {
                Stock::updateOrCreate(
                    ['location_id' => $location->id, 'product_id' => $product->id],
                    ['quantity' => $value]
                );
            }
        }
    }
}
