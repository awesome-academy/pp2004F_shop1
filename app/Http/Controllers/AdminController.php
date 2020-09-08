<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin_def.pages.index');
    }

    public function page404()
    {
        return response()->view('admin_def.pages.404', [], 404);
    }

    public function login()
    {
        return view('admin_def.pages.login');
    }

    public function media()
    {
        if (\Auth::user()->can('Create New Product', Product::class) || \Auth::user()->can('Update Product', Product::class)) {
            return view('admin_def.pages.media');
        } else {
            return view403();
        }
    }
}
