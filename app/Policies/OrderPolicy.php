<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Traits\PolicyTrait;

class OrderPolicy
{
    use HandlesAuthorization;

    use PolicyTrait;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $this->is_allowed($user, 'View Order List');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $this->is_allowed($user, 'View Order Details');
    }

    public function updateAsShipper(User $user)
    {
        return $this->is_allowed($user, 'Update Order As Shipper');
    }

    public function updateAsAdmin(User $user)
    {
        return $this->is_allowed($user, 'Update Order As Admin');
    }
}
