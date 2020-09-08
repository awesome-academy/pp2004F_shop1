<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    const ROLE = [
        'unactived' => 1,
        'default' => 2,
        'superadmin' => 3,
    ];

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'activated_at',
        'remember_token',
        'role_id',
        'address1',
        'address2',
        'city',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'activated_at' => 'datetime',
    ];

    public function getFullName()
    {
        return ($this->last_name && $this->first_name) ? "{$this->last_name} {$this->first_name}" : '';
    }

    public function isAdmin()
    {
        return $this->role_id >= self::ROLE['superadmin'];
    }

    public function hasOrders()
    {
        return $this->hasMany(Order::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
