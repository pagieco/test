<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Asset;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the assets.
     *
     * @param  \App\Models\User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return $user->hasAccess('asset:list');
    }

    /**
     * Determine whether the user can view the asset.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Asset $asset
     * @return bool
     */
    public function view(User $user, Asset $asset): bool
    {
        return $user->hasAccess('asset:view')
            && $user->currentProject()->assets->contains($asset->local_id);
    }

    /**
     * Determeine whether the user can upload an asset.
     *
     * @param  \App\Models\User $user
     * @return bool
     */
    public function upload(User $user): bool
    {
        return $user->hasAccess('asset:upload');
    }

    /**
     * Determine whether the user can update an asset.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Asset $asset
     * @return bool
     */
    public function update(User $user, Asset $asset): bool
    {
        return $user->hasAccess('asset:update')
            && $user->currentProject()->assets->contains($asset->local_id);
    }

    /**
     * Determine whether the user can move an asset.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Asset $asset
     * @return bool
     */
    public function move(User $user, Asset $asset): bool
    {
        return $user->hasAccess('asset:move')
            && $user->currentProject()->assets->contains($asset->local_id);
    }

    /**
     * Determine whether the user can delete the asset.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Asset $asset
     * @return bool
     */
    public function delete(User $user, Asset $asset): bool
    {
        return $user->hasAccess('asset:delete')
            && $user->currentProject()->assets->contains($asset->local_id);
    }
}
