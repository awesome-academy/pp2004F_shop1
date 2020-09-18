<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'key',
        'value',
        'parent_id',
        'type',
    ];

    public $timestamps = false;

    public CONST TYPE = [
        'group' => 1,
        'item' => 2,
        'text' => 3,
        'textarea' => 4,
        'image' => 5,
        'select' => 6,
        'checkbox' => 7,
    ];
}
