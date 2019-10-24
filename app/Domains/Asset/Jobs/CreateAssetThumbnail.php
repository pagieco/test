<?php

namespace App\Domains\Asset\Jobs;

use Illuminate\Bus\Queueable;
use App\Domains\Asset\Models\Asset;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateAssetThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The asset instance.
     *
     * @var \App\Domains\Asset\Models\Asset
     */
    protected $asset;

    /**
     * Create a new job instance.
     *
     * @param  \App\Domains\Asset\Models\Asset $asset
     * @return void
     */
    public function __construct(Asset $asset)
    {
        $this->asset = $asset;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->asset->createThumbnail();
    }
}
