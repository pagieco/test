<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetPolicy
{
    use HandlesAuthorization;

    public function list(User $user): bool
    {
        return $user->hasAccess('asset:list');
    }
}
