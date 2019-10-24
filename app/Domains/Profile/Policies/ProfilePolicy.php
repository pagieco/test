<?php

namespace App\Domains\Profile\Policies;

use App\Domains\User\Models\User;
use App\Domains\Profile\Models\Profile;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the profiles.
     *
     * @param  \App\Domains\User\Models\User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return $user->hasAccess('profile:list');
    }

    /**
     * Determine whether the user can view the profile.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Profile\Models\Profile $profile
     * @return bool
     */
    public function view(User $user, Profile $profile): bool
    {
        return $user->hasAccess('profile:view')
            && (int) $profile->project_id === (int) $user->current_project_id;
    }

    /**
     * Determine whether the user can update the profile.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Profile\Models\Profile $profile
     * @return bool
     */
    public function update(User $user, Profile $profile): bool
    {
        return $user->hasAccess('profile:update')
            && (int) $profile->project_id === (int) $user->current_project_id;
    }

    /**
     * Determine whether the user can delete the profile.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Profile\Models\Profile $profile
     * @return bool
     */
    public function delete(User $user, Profile $profile): bool
    {
        return $user->hasAccess('profile:delete')
            && (int) $profile->project_id === (int) $user->current_project_id;
    }

    /**
     * Determine whether the user can list the profile events.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Profile\Models\Profile $profile
     * @return bool
     */
    public function listEvents(User $user, Profile $profile): bool
    {
        return $user->hasAccess('profile:list-events')
            && (int) $profile->project_id === (int) $user->current_project_id;
    }

    /**
     * Determine whether the user can view a profile event.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Profile\Models\Profile $profile
     * @return bool
     */
    public function viewEvent(User $user, Profile $profile): bool
    {
        return $user->hasAccess('profile:view-event')
            && (int) $profile->project_id === (int) $user->current_project_id;
    }
}
