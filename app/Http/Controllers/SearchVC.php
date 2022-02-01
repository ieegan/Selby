<?php

namespace App\Http\Controllers;

use App\Product;
use App\SProduct;
use Illuminate\Http\Request;

class SearchVC extends Controller
{
    public function products()
    {
        if (request()->q) {
            if (request()->s) {
                return SProduct::search(request()->q)->limit(10)->get();
            } else {
                return Product::search(request()->q)->limit(10)->get();
            }
        } else {
            return [];
        }
    }
}
