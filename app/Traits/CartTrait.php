<?php

namespace App\Traits;

use App\Models\Product;

trait CartTrait {
    public function emptyCart()
    {
        session()->put('cart', []);
        session()->put('cart-quantity', []);
    }

    protected function getCartDetails()
    {
        $cart = session()->get('cart');
        if (!empty($cart)) {
            $products = Product::find($cart);
            $total = $products->sum('current_price');
            $quantity = session()->get('cart-quantity');
            if (!empty($quantity)){
                foreach ($quantity as $key => $value) {
                    foreach($products as $product) {
                        if ($product->id === $key) {
                            $total += $product->current_price * ($value - 1);
                        }
                    }
                }
            }
            return [
                'count' => count($cart),
                'total' => $total,
            ];
        } else {
            return [
                'count' => 0,
                'total' => 0,
            ];
        }
    }
}
