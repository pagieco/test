<?php

namespace Tests\Unit\Models\Observers;

use Tests\TestCase;
use App\Models\Asset;
use App\Jobs\CreateAssetThumbnail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssetObserverTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_the_original_filename_attribute_when_the_creating_event_is_triggered()
    {
        $asset = factory(Asset::class)->create();

        $this->assertNotNull($asset->original_filename);
    }

    /** @test */
    public function it_dipatches_the_create_asset_thumbnail_job_when_the_created_event_is_triggered()
    {
        $this->expectsJobs(CreateAssetThumbnail::class);

        factory(Asset::class)->create();
    }
}
