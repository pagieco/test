<?php

namespace App\Domains\Asset\Policies;

use App\Domains\User\Models\User;
use App\Domains\Asset\Models\AssetFolder;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetFolderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the asset folders.
     *
     * @param  \App\Domains\User\Models\User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return $user->hasAccess('asset-folder:list');
    }

    /**
     * Determine whether the user can view the asset folder.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Asset\Models\AssetFolder $assetFolder
     * @return bool
     */
    public function view(User $user, AssetFolder $assetFolder): bool
    {
        return $user->hasAccess('asset-folder:view')
            && $user->currentProject()->assetFolders->contains($assetFolder->local_id);
    }

    /**
     * Determine whether the user can create a new asset folder.
     *
     * @param  \App\Domains\User\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAccess('asset-folder:create');
    }

    /**
     * Determine whether the user can update the asset folder.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Asset\Models\AssetFolder $assetFolder
     * @return bool
     */
    public function update(User $user, AssetFolder $assetFolder): bool
    {
        return $user->hasAccess('asset-folder:update')
            && $user->currentProject()->assetFolders->contains($assetFolder->local_id);
    }

    /**
     * Determine whether the user can delete the asset folder.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Asset\Models\AssetFolder $assetFolder
     * @return bool
     */
    public function delete(User $user, AssetFolder $assetFolder): bool
    {
        return $user->hasAccess('asset-folder:delete')
            && $user->currentProject()->assetFolders->contains($assetFolder->local_id);
    }
}
