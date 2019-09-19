<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Domain;
use Illuminate\Auth\Access\HandlesAuthorization;

class DomainPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the domains.
     *
     * @param  \App\Models\User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return $user->hasAccess('domain:list');
    }

    /**
     * Determine whether the user can view the domain.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Domain $domain
     * @return bool
     */
    public function view(User $user, Domain $domain): bool
    {
        return $user->hasAccess('domain:view')
            && $user->currentProject()->domains->contains($domain->id);
    }
}
