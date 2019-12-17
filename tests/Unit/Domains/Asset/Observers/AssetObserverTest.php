<?php

namespace Tests\Unit\Domains\Asset\Observers;

use Tests\TestCase;
use App\Domains\Asset\Models\Asset;
use App\Domains\Project\Models\Project;
use App\Domains\Asset\Jobs\CreateAssetThumbnail;
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

    /** @test */
    public function it_increments_used_storage_when_creating_an_asset()
    {
        $project = factory(Project::class)->create();

        $asset = factory(Asset::class)->create([
            'project_id' => $project->id,
        ]);

        $project->refresh();

        $this->assertEquals($asset->file_size, $project->used_storage);
    }

    /** @test */
    public function it_decrements_used_storage_when_deleting_an_asset()
    {
        $asset = factory(Asset::class)->create();

        $used = $asset->project->used_storage;

        $asset->delete();

        $this->assertEquals($used - $asset->file_size, $asset->project->used_storage);
    }
}
