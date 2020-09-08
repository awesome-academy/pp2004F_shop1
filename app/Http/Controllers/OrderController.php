<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Bill;
use App\Models\Product;
use App\Traits\CartTrait;

class OrderController extends Controller
{
    use CartTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        if ($user->can('viewAny', Order::class)) {
            $orders = Order::with('log:id,updated_at', 'orderedProducts:product_id', 'customer:id,first_name,last_name')
                ->orderBy('id', 'desc')->get();
            return view('admin_def.pages.order_index', compact('orders'));
        } else {
            return view403();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!\Auth::check() || empty($request->cart)) {
            return redirect()->back();
        }
        $request['status'] = Order::STT['pending'];
        $request['customer_id'] = \Auth::user()->id;
        $order = Order::create($request->all());
        $details_flag = true;
        foreach($request->cart as $item) {
            $product = Product::find($item);
            $details_flag = $product->inOrder()->save($order, [
                'price' => $product->current_price,
                'quantity_ordered' => (isset($request->$item)) ? $request->$item : 1,
            ]);
        }
        if ($order && $details_flag) {
            $this->emptyCart();
            return redirect('/')->withMessage('You have ordered successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \Auth::user();
        if ($user->can('view', Order::class)) {
            $order = Order::with('orderedProducts')->findOrFail($id);
            return view('admin_def.pages.order_show', compact('order'));
        } else {
            return view403();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $user = \Auth::user();
        $user_can = [];
        if ($user->can('updateAsShipper', Order::class)) {
            array_push($user_can, Order::STT['on_shipping'], Order::STT['shipped']);
        }
        if ($user->can('updateAsAdmin', Order::class)) {
            array_push($user_can, Order::STT['completed']);
        }
        return view('admin_def.pages.order_edit', compact('order', 'user_can'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = \Auth::user();
        if (($user->can('updateAsShipper', Order::class) && 
            ($request->status == Order::STT['on_shipping'] || $request->status == Order::STT['shipped']))
            || ($user->can('updateAsAdmin', Order::class) && $request->status == Order::STT['completed'])
            ) {
            try {
                $order = Order::find($id);
                if ($request->status == $order->status || $order->status == Order::STT['completed']) {
                    return redirect()->route('admin.order.show', $id);
                }
                $order->fill($request->all());
                $update = $order->save();
                if ($update) {
                    if ($order->status == Order::STT['completed']) {
                        $this->createBill($order);
                    }
                    $order->log()->create([
                        'order_id' => $order->id,
                        'user_id' => \Auth::user()->id,
                        'event' => $request->status,
                    ]);
                    return redirect()->route('admin.order.show', $id);
                }
            } catch (\Exception $e) {
                // return redirect()->back()->withErrors($e->getMessage());
            }
        }
        return redirect()->back()->withErrors("Permission Denied! You do not have permission to do this action");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function createBill($order)
    {
        try {
            Bill::create([
            'check_number' => rand(1000000000000000, 9999999999999999),
            'amount' => $order->getAmount(true),
            'order_id' => $order->id,
            ]);
        } catch(\Exception $e) {

        }
    }
}
