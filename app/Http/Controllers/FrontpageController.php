<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontpageController extends Controller
{
    public function home()
    {
        return view('frontpage_def.pages.index');
    }

    public function productList()
    {
        return view('frontpage_def.pages.product_list');
    }

    public function productDetails()
    {
        return view('frontpage_def.pages.product_details');
    }

    public function about()
    {
        return view('frontpage_def.pages.about');
    }

    public function contact()
    {
        return view('frontpage_def.pages.contact');
    }

    public function checkout()
    {
        return view('frontpage_def.pages.checkout');
    }

    public function cart()
    {
        return view('frontpage_def.pages.cart');
    }

    public function login()
    {
        return view('frontpage_def.pages.login');
    }

    public function register()
    {
        return view('frontpage_def.pages.register');
    }

    public function search()
    {
        return view('frontpage_def.pages.search');
    }

}
