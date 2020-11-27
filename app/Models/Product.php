<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'product_code',
        'slug',
        'buy_price',
        'current_price',
        'quantity_in_stock',
        'excerpt',
        'description',
        'brand_id',
        'properties',
        'sale_off',
        'sale_off_from',
        'sale_off_to',
    ];

    protected $casts = [
        'properties' => Json::class,
        'sale_off_from' => 'datetime',
        'sale_off_to' => 'datetime',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function inOrder()
    {
        return $this->belongsToMany(Order::class, 'order_details', 'product_id', 'order_id')
            ->withPivot('price', 'quantity_ordered');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function thumb()
    {
        return $this->hasOne(ProductImage::class);
    }

    public function getThumb($src = null)
    {
        if ($src === null && !empty($this->thumb)) {
            $src = $this->thumb->image;
        }
        return preg_replace('#(.*)(\/)(.*)$#', '$1/thumbs/$3', $src);
    }

    public function vnd_format($quantity= 1, $multiply = 1000)
    {
        return vnd_format($this->current_price, $quantity, $multiply);
    }

    public function getPropKey($input)
    {
        $rs = explode('.', $input);
        return $rs[1];
    }

    public function getProps()
    {
        return collect(json_decode($this->properties))->sortKeys();
    }

    public function cartQuantity()
    {
        $quantity = session()->get('cart-quantity');
        if (!empty($quantity) && array_key_exists($this->id, $quantity)) {
            return $quantity[$this->id];
        }
    }

    public function getTotalSales()
    {
        $sales = \DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('status', Order::STT['completed'])
            ->where('product_id', $this->id)
            ->sum('quantity_ordered');
        return $sales;
    }

    public function getTotalAmount()
    {
        $total = \DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('status', Order::STT['completed'])
            ->where('product_id', $this->id)
            ->sum(\DB::RAW('quantity_ordered * price'));
        return $total;
    }
}
