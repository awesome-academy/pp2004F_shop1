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

Route::get('/', 'FrontpageController@home');
Route::get('product-list', 'FrontpageController@productList');
Route::get('product/{product}', 'FrontpageController@productDetails');
Route::get('about', 'FrontpageController@about');
Route::get('contact', 'FrontpageController@contact');
Route::get('checkout', 'FrontpageController@checkout');
Route::get('cart', 'FrontpageController@cart');
Route::get('login', 'FrontpageController@login');
Route::get('register', 'FrontpageController@register');
Route::get('search', 'FrontpageController@search');

// Admin Route Group

Route::prefix('admin')->as('admin.')->group(function(){
    Route::fallback('AdminController@page404');
    Route::get('login', 'AdminController@login');
    Route::get('/', 'AdminController@dashboard');
});
