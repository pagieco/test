<?php

namespace App\Models\Observers;

use App\Models\Asset;
use App\Jobs\CreateAssetThumbnail;

class AssetObserver
{
    public function creating(Asset $asset): void
    {
        $asset->setAttribute('original_filename', $asset->filename);
    }

    public function created(Asset $asset): void
    {
        CreateAssetThumbnail::dispatch($asset);
    }
}
