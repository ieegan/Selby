<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('stocks/{product}', 'StockVC@product')->name('stock.product');

Route::get('search/products', 'SearchVC@products')->name('search.products');

Route::get('sync/products', 'SyncVC@products')->name('sync.products');
Route::get('sync/stocks/{location}', 'SyncVC@stocks')->name('sync.stocks');

Route::prefix('/')->middleware(['auth'])->group(function () {
    Route::get('/', 'DashboardController@index')->name('home');

    Route::resources([
        'user' => 'UserController',
    ]);
});
