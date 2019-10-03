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
            && $profile->project_id === $user->current_project_id;
    }

    /**
     * Determine whether the user can update the profile.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Profile $profile
     * @return bool
     */
    public function update(User $user, Profile $profile): bool
    {
        return $user->hasAccess('profile:update')
            && $profile->project_id === $user->current_project_id;
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
            && $profile->project_id === $user->current_project_id;
    }

    /**
     * Determine whether the user can list the profile events.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Profile $profile
     * @return bool
     */
    public function listEvents(User $user, Profile $profile): bool
    {
        return $user->hasAccess('profile:list-events')
            && $profile->project_id === $user->current_project_id;
    }

    /**
     * Determine whether the user can view a profile event.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Profile $profile
     * @return bool
     */
    public function viewEvent(User $user, Profile $profile): bool
    {
        return $user->hasAccess('profile:view-event')
            && $profile->project_id === $user->current_project_id;
    }
}
