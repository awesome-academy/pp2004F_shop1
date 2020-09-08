<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;

class BillController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        if ($user->can('viewAny', Bill::class)) {
            $bills = Bill::with('order', 'order.orderedProducts', 'order.customer:id,first_name,last_name')
                ->orderBy('id', 'desc')->get();
            return view('admin_def.pages.bill_index', compact('bills'));
        } else {
            return view403();
        }
        
    }

    public function show($id)
    {
        $user = \Auth::user();
        if ($user->can('view', Bill::class)) {
            $bill = Bill::findOrFail($id);
            $order = $bill->order;
            return view('admin_def.pages.bill_show', compact('bill', 'order'));
        } else {
            return view403();
        }
    }
}
