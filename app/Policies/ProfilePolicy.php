<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the profiles.
     *
     * @param  \App\Models\User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return $user->hasAccess('profile:list');
    }

    /**
     * Determine whether the user can view the profile.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Profile $profile
     * @return bool
     */
    public function view(User $user, Profile $profile): bool
    {
        return $user->hasAccess('profile:view')
            && $user->currentProject()->profiles->contains($profile->id);
    }

    /**
     * Determine whether the user can delete the profile.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Profile $profile
     * @return bool
     */
    public function delete(User $user, Profile $profile): bool
    {
        return $user->hasAccess('profile:delete')
            && $user->currentProject()->profiles->contains($profile->id);
    }
}
