<?php

namespace App\Domains\Domain\Policies;

use App\Domains\User\Models\User;
use App\Domains\Domain\Models\Domain;
use Illuminate\Auth\Access\HandlesAuthorization;

class DomainPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the domains.
     *
     * @param  \App\Domains\User\Models\User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return $user->hasAccess('domain:list');
    }

    /**
     * Determine whether the user can view the domain.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Domain\Models\Domain $domain
     * @return bool
     */
    public function view(User $user, Domain $domain): bool
    {
        return $user->hasAccess('domain:view')
            && $user->currentProject()->domains->contains($domain->id);
    }

    /**
     * Determine whether the user can create a new domain.
     *
     * @param  \App\Domains\User\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAccess('domain:create');
    }

    /**
     * Determine whether the user can update the domain.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Domain\Models\Domain $domain
     * @return bool
     */
    public function update(User $user, Domain $domain): bool
    {
        return $user->hasAccess('domain:update')
            && $user->currentProject()->domains->contains($domain->id);
    }

    /**
     * Determine whether the user can delete the domain.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Domain\Models\Domain $domain
     * @return bool
     */
    public function delete(User $user, Domain $domain): bool
    {
        return $user->hasAccess('domain:delete')
            && $user->currentProject()->domains->contains($domain->id);
    }
}
