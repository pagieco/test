<?php

namespace App\Domains\Automation\Policies;

use App\Domains\User\Models\User;
use App\Domains\Automation\Models\Automation;
use Illuminate\Auth\Access\HandlesAuthorization;

class AutomationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the automations.
     *
     * @param  \App\Domains\User\Models\User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return $user->hasAccess('automation:list');
    }

    /**
     * Determine whether the user can view the automation.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Automation\Models\Automation $automation
     * @return bool
     */
    public function view(User $user, Automation $automation): bool
    {
        return $user->hasAccess('automation:view')
            && $user->currentProject()->automations->contains($automation->id);
    }

    /**
     * Determine whether the user can delete the automation.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Automation\Models\Automation $automation
     * @return bool
     */
    public function delete(User $user, Automation $automation): bool
    {
        return $user->hasAccess('automation:delete')
            && $user->currentProject()->automations->contains($automation->id);
    }
}
