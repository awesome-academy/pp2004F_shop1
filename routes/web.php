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
// app('debugbar')->disable();

Route::get('/', 'FrontpageController@home')->name('homepage');

Route::get('brand/{id}', 'FrontpageController@brand');

Route::get('product/{product}', 'FrontpageController@productDetails')->name('product.details');

Route::get('product/{product}/ajax', 'FrontpageController@ajaxProduct');

Route::get('cart/ajax', 'FrontpageController@ajaxCart');

Route::get('cart/{product}/ajaxAdd/{quantity?}', 'FrontpageController@ajaxAddCart');

Route::get('cart/{product}/ajaxRemove', 'FrontpageController@ajaxRemoveCart');

Route::get('cart/ajaxEmpty', 'FrontpageController@ajaxEmptyCart');

Route::get('about', 'FrontpageController@about');

Route::get('contact', 'FrontpageController@contact')->name('contact_index');

Route::post('contact/save', 'ContactController@save')->name('contact_save');

Route::get('checkout', 'FrontpageController@checkout');

Route::get('cart', 'FrontpageController@cart');

Route::get('login', 'FrontpageController@login');

Route::get('register', 'FrontpageController@register')->name('register');

Route::post('register', 'UserController@store')->name('register.submit');

Route::get('search/submit', 'FrontpageController@searchSubmit')->name('search.submit');

Route::get('search', 'FrontpageController@search');

Route::post('login', 'Auth\LoginController@login')->name('login');

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

/*
|--------------------------------------------------------------------------
| User Route Group
|--------------------------------------------------------------------------
*/

Route::prefix('user')->as('user.')->group(function(){
    Route::get('account', 'FrontpageController@userAccount')->name('account');

    Route::get('account/{id}/edit', 'FrontpageController@userEditProfile')->name('account.edit');

    Route::match(['PUT', 'PATCH'], 'account/update', 'FrontpageController@userUpdateProfile')->name('account.update');

    Route::get('order', 'FrontpageController@userOrderIndex')->name('orders');

    Route::get('order/{id}/show', 'FrontpageController@userOrderShow')->name('order.show');

    Route::get('billing', 'FrontpageController@userBillIndex')->name('bills');

    Route::get('bill/{id}/show', 'FrontpageController@userBillShow')->name('bill.show');

    Route::post('order/store', 'OrderController@store')->name('order.store');
});

/*
|--------------------------------------------------------------------------
| Admin Route Group
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->as('admin.')->middleware('auth.admin')->group(function(){
    Route::fallback('AdminController@page404')->name('404');

    Route::get('login', 'AdminController@login');

    Route::post('login', 'Auth\LoginController@login')->name('login');

    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/', 'AdminController@dashboard')->name('dashboard');

    Route::resource('product', 'ProductController');

    Route::resource('order', 'OrderController')->except(['create', 'store', 'destroy']);

    Route::resource('bill', 'BillController')->only(['index', 'show']);

    Route::resource('brand', 'BrandController')->except(['create', 'edit']);

    Route::get('user-admin/index', 'UserController@admin')->name('user.admin');

    Route::match(['PUT', 'PATCH'], 'user/{id}/update-profile', 'UserController@updateProfile')->name('user.updateProfile');

    Route::resource('user', 'UserController');

    Route::resource('role', 'RoleController');

    Route::get('contact/index', 'ContactController@contact')->name('contact.index');

    Route::get('contact/{id}/show', 'ContactController@show')->name('contact.show');

    Route::get('media', 'AdminController@media');

    Route::group(['prefix' => 'filemanager', 'middleware' => ['web']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    Route::view('forbidden', 'admin_def.pages.403')->name('forbidden');
});
