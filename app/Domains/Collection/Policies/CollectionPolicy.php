<?php

namespace App\Domains\Collection\Policies;

use App\Domains\User\Models\User;
use App\Domains\Collection\Models\Collection;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Domains\Collection\Models\CollectionEntry;

class CollectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the collections.
     *
     * @param  \App\Domains\User\Models\User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return $user->hasAccess('collection:list');
    }

    /**
     * Determine whether the user can view the collection.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Collection\Models\Collection $collection
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
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Collection\Models\Collection $collection
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
     * @param  \App\Domains\User\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAccess('collection:create');
    }

    /**
     * Determine whether the user can delete the collection.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Collection\Models\Collection $collection
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
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Collection\Models\Collection $collection
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
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Collection\Models\Collection $collection
     * @return bool
     */
    public function deleteEntry(User $user, Collection $collection): bool
    {
        return $user->hasAccess('collection:delete-entry')
            && $user->currentProject()->collections->contains($collection->local_id);
    }

    /**
     * Determine whether the user can list entries from the given collection.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Collection\Models\Collection $collection
     * @return bool
     */
    public function listEntries(User $user, Collection $collection): bool
    {
        return $user->hasAccess('collection:list-entries')
            && $user->currentProject()->collections->contains($collection->local_id);
    }

    /**
     * Determine whether the user can update the given entry.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Collection\Models\CollectionEntry $entry
     * @return bool
     */
    public function updateEntry(User $user, CollectionEntry $entry): bool
    {
        return $user->hasAccess('collection:update-entry')
            && $user->currentProject()->collections->contains($entry->collection_id);
    }
}
