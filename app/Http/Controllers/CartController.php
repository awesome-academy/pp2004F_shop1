<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Traits\CartTrait;

class CartController extends Controller
{
    use CartTrait;

    public function ajaxProduct(Request $request)
    {
        $product = Product::find($request->product);
        if ($product) {
            $html = view('frontpage_def.partials.modal_product_preview')->with('product', $product)->render();
            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        } else {
            return false;
        }
    }

    public function ajaxCart(Request $request)
    {
        $cart = session()->get('cart');
        $products = Product::with('images')->find($cart);
        $quantity = session()->get('cart-quantity');
        if ($quantity) {
            foreach ($quantity as $key => $value) {
                foreach($products as $product) {
                    if ($product->id === $key) {
                        $product->quantity = $value;
                    }
                }
            }
        }
        if ($products) {
            return response()->json([
                'success' => true,
                'data' => $products,
            ]);
        } else {
            return false;
        }
    }

    public function ajaxAddCart(Request $request)
    {
        $cart = session()->get('cart');
        if (empty($cart) || !in_array($request->product, $cart)) {
            session()->push('cart', $request->product);
        }
        $cart = session()->get('cart');
        if ($request->quantity || ( !empty($quantity = session()->get('cart-quantity')) 
        && array_key_exists($request->product, $quantity)
        && session()->get('cart-quantity')[$request->product] !== $request->quantity)) {
            session()->put('cart-quantity.' . $request->product, $request->quantity);
        }
        if (in_array($request->product, $cart)) {
            return response()->json([
                'success' => true,
                'data' => $this->getCartDetails(),
            ]);
        }
    }

    public function ajaxRemoveCart(Request $request)
    {
        $cart = session()->pull('cart', []);
        $key = array_search($request->product, $cart);
        if ($key !== false) {
            unset($cart[$key]);
        }
        session()->put('cart', $cart);
        $quantity = session()->pull('cart-quantity', []);
        if (array_key_exists($request->product, $quantity)) {
            unset($quantity[$request->product]);
        }
        session()->put('cart-quantity', $quantity);
        if (!in_array($request->product, $cart)) {
            return response()->json([
                'success' => true,
                'data' => $this->getCartDetails(),
            ]);
        }
    }

    public function ajaxEmptyCart()
    {
        $this->emptyCart();
        if (empty(session()->get('cart'))) {
            return response()->json(true);
        }
    }
}
