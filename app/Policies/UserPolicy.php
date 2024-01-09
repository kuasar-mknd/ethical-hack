<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function updateRole(User $user)
    {
        return in_array($user->role, ['Administrateur']);
    }
}
