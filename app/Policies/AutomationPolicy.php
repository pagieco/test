<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Automation;
use Illuminate\Auth\Access\HandlesAuthorization;

class AutomationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the automations.
     *
     * @param  \App\Models\User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return $user->hasAccess('automation:list');
    }

    /**
     * Determine whether the user can view the automation.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Automation $automation
     * @return bool
     */
    public function view(User $user, Automation $automation): bool
    {
        return $user->hasAccess('automation:view')
            && $user->currentProject()->automations->contains($automation->id);
    }
}
