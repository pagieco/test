<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Asset;
use App\Models\AssetFolder;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetFolderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $this->assertInstanceOf(BelongsTo::class, app(AssetFolder::class)->project());
    }

    /** @test */
    public function it_has_many_assets()
    {
        $this->assertInstanceOf(HasMany::class, app(AssetFolder::class)->assets());
    }

    /** @test */
    public function it_can_insert_a_new_record()
    {
        $this->assertDatabaseHas('asset_folders', [
            'local_id' => factory(AssetFolder::class)->create()->local_id,
        ]);
    }

    /** @test */
    public function it_wont_delete_the_related_assets_when_deleting_an_asset_folder()
    {
        $folder = factory(AssetFolder::class)->create();

        factory(Asset::class)->create([
            'asset_folder_id' => $folder->local_id,
        ]);

        $folder->refresh();

        $this->assertCount(1, $folder->assets);
        $this->assertEquals(1, DB::table('assets')->count());

        $folder->delete();

        $this->assertEquals(1, DB::table('assets')->count());
    }
}
