<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class StockVC extends Controller
{
    public function product(Product $product)
    {
        return $product->stocks->load('location');
    }
}
