<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\User;

trait PolicyTrait {
    public function is_allowed($user, $action)
    {
        $allowed = $user->role->role_permission;
        $permissions = Permission::where('title', $action)->pluck('id')->first();
        if (\Str::contains($allowed, ',')) {
            $allowed = explode(',', $allowed);
            return in_array($permissions, $allowed);
        } else {
            if ($user->role_id == User::ROLE['superadmin']) {
                return TRUE;
            }
            return $allowed == $permissions;
        }
        return FALSE;
    }
}