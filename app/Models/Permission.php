<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'title',
        'permission_group',
        'description',
    ];

    public $timestamps = false;
}
