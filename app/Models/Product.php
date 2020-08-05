<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'buy_price',
        'current_price',
        'quantity_in_stock',
        'description',
        'sale_off',
        'brand_id',
        'properties',
    ];

    protected $casts = [
        'properties' => Json::class,
    ];
}
