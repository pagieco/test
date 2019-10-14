<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Collection;
use Illuminate\Auth\Access\HandlesAuthorization;

class CollectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the collections.
     *
     * @param  \App\Models\User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return $user->hasAccess('collection:list');
    }

    /**
     * Determine whether the user can view the collection.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Collection $collection
     * @return bool
     */
    public function view(User $user, Collection $collection): bool
    {
        return $user->hasAccess('collection:view')
            && $user->currentProject()->collections->contains($collection->local_id);
    }

    /**
     * Determine whether the user can update the collection.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Collection $collection
     * @return bool
     */
    public function update(User $user, Collection $collection): bool
    {
        return $user->hasAccess('collection:update')
            && $user->currentProject()->collections->contains($collection->local_id);
    }

    /**
     * Determine whether the user can create a new collection.
     *
     * @param  \App\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAccess('collection:create');
    }

    /**
     * Determine whether the user can delete the collection.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Collection $collection
     * @return bool
     */
    public function delete(User $user, Collection $collection): bool
    {
        return $user->hasAccess('collection:delete')
            && $user->currentProject()->collections->contains($collection->local_id);
    }

    /**
     * Determine whether the user can create a new collection entry.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Collection $collection
     * @return bool
     */
    public function createEntry(User $user, Collection $collection): bool
    {
        return $user->hasAccess('collection:create-entry')
            && $user->currentProject()->collections->contains($collection->local_id);
    }

    /**
     * Determine whether the user can delete the given entry.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Collection $collection
     * @return bool
     */
    public function deleteEntry(User $user, Collection $collection): bool
    {
        return $user->hasAccess('collection:delete-entry')
            && $user->currentProject()->collections->contains($collection->local_id);
    }
}
