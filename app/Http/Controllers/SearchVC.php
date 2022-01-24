<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class SearchVC extends Controller
{
    public function products()
    {
        if (request()->q) {
            return Product::search(request()->q)->limit(10)->get();
        } else {
            return [];
        }
    }
}
