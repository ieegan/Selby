<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Country;
use App\Customer;
use App\Outlet;
use App\Page;
use App\Product;
use App\Slide;
use App\Variation;
use App\Vendor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $slides = Slide::active()->order()->get();
        $recentProducts = Product::recent()->active()->get();
        $featuredProducts = Product::featured()->active()->get();

        return view('home.index', compact('recentProducts','featuredProducts','slides'));
    }
}

