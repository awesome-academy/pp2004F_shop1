<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getSalesLastMonth()
    {
        $orders = Order::where('status', Order::STT['completed'])
            ->whereMonth('created_at', now()->subMonth()->format('m'))
            ->pluck('id');
        $products = Product::where('brand_id', $this->id)->pluck('id');
        $sales = \DB::table('order_details')->whereIn('order_id', $orders)->whereIn('product_id', $products)
            ->sum('quantity_ordered');
        return $sales;
    }

    public function getAmountLastMonth()
    {
        $orders = Order::where('status', Order::STT['completed'])
            ->whereMonth('created_at', now()->subMonth()->format('m'))
            ->pluck('id');
        $products = Product::where('brand_id', $this->id)->pluck('id');
        $sales = \DB::table('order_details')->whereIn('order_id', $orders)->whereIn('product_id', $products)
            ->sum(\DB::RAW('quantity_ordered * price'));
        return $sales;
    }
}
