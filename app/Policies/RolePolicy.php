<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Traits\PolicyTrait;

class RolePolicy
{
    use HandlesAuthorization;

    use PolicyTrait;

    public function manageRole(User $user)
    {
        return $this->is_allowed($user, 'Manage Admin Role');
    }
}
