<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'role_permission',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
