<?php

namespace Tests\Unit\Domains\Asset\Jobs;

use Tests\TestCase;
use App\Domains\Asset\Models\Asset;
use Illuminate\Support\Facades\Storage;
use App\Domains\Asset\Jobs\CreateAssetThumbnail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateAssetThumbnailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_thumbnail_when_dispatching_the_job()
    {
        Storage::fake();

        $this->withoutEvents();

        $asset = factory(Asset::class)->create();

        Storage::disk()->assertMissing($asset->thumb_path);

        $job = new CreateAssetThumbnail($asset);
        $job->handle();

        Storage::disk()->assertExists($asset->thumb_path);
    }
}
