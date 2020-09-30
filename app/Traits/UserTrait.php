<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;

trait UserTrait {
    public function getOrders($user, $paginate = null)
    {
        if (!empty($user)) {
            $orders = Order::where('customer_id', $user->id)->orderBy('id', 'desc');
            if ($paginate === null) {
                $orders = $orders->paginate(1);
            }
            if ($paginate === false) {
                $orders = $orders->get();
            }
            if (is_int($paginate)) {
                $orders = $orders->paginate($paginate);
            }
            return $orders;
        }
        return false;
    }
    
    public function getOrderDetails($orderId)
    {
        if (!empty($orderId)) {
            $order = Order::find($orderId);
            return $order;
        }
        return false;
    }
    
    public function getBills($user, $paginate = null)
    {
        if (!empty($user)) {
            $bills = Order::where('customer_id', $user->id)->where('status', Order::STT['completed'])->orderBy('id', 'desc');
            if ($paginate === null) {
                $bills = $bills->paginate(20);
            }
            if ($paginate === false) {
                $bills = $bills->take(20)->get();
            }
            if (is_int($paginate)) {
                $bills = $bills->paginate($paginate);
            }
            return $bills;
        }
        return false;
    }
}
