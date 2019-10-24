<?php

namespace App\Domains\Asset\Observers;

use App\Domains\Asset\Models\Asset;
use App\Domains\Asset\Jobs\CreateAssetThumbnail;

class AssetObserver
{
    /**
     * Listen to the asset model "creating" event.
     *
     * @param  \App\Domains\Asset\Models\Asset $asset
     * @return void
     */
    public function creating(Asset $asset): void
    {
        $asset->setAttribute('original_filename', $asset->filename);
    }

    /**
     * Listen to the asset model "created" event.
     *
     * @param  \App\Domains\Asset\Models\Asset $asset
     * @return void
     */
    public function created(Asset $asset): void
    {
        CreateAssetThumbnail::dispatch($asset);

        $asset->project->incrementUsedStorageWith($asset->filesize);
    }

    public function deleted(Asset $asset)
    {
        $asset->project->decrementUsedStorageBy($asset->filesize);
    }
}
