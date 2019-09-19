<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Asset;
use App\Models\Project;
use App\Models\AssetFolder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $this->assertInstanceOf(BelongsTo::class, app(Asset::class)->project());
    }

    /** @test */
    public function it_belongs_to_a_folder()
    {
        $this->assertInstanceOf(BelongsTo::class, app(Asset::class)->folder());
    }

    /** @test */
    public function it_can_insert_a_new_record()
    {
        $this->assertDatabaseHas('assets', [
            'id' => factory(Asset::class)->create()->id,
        ]);
    }

    /** @test */
    public function it_can_get_the_hash_path_attribute()
    {
        $asset = factory(Asset::class)->create([
            'hash' => 'test-hash',
        ]);

        $this->assertEquals('id=test-hash', explode('?', $asset->hash_path)[1]);
    }

    /** @test */
    public function it_can_be_unlinked()
    {
        Storage::fake();

        $asset = factory(Asset::class)->create();

        Storage::disk()->assertExists($asset->path);

        $asset->unlink();

        Storage::disk()->assertMissing($asset->path);

        $this->assertNull(Asset::find($asset->id));
    }

    /** @test */
    public function it_can_get_the_path_from_the_storage()
    {
        $this->assertEquals(Storage::disk()->path('test'), (new Asset)->getPath('test'));
    }

    /** @test */
    public function it_can_get_the_path_from_an_asset()
    {
        $asset = factory(Asset::class)->create();

        $this->assertStringEndsWith($asset->filename, $asset->getPath());
    }

    /** @test */
    public function it_returns_true_when_the_asset_is_an_image_based_on_the_mimetype()
    {
        $asset = factory(Asset::class)->create([
            'mimetype' => 'image/jpeg',
        ]);

        $this->assertTrue($asset->isImage());
    }

    /** @test */
    public function it_returns_false_when_the_asset_is_not_an_image_based_on_the_mimetype()
    {
        $asset = factory(Asset::class)->create([
            'mimetype' => 'application/pdf',
        ]);

        $this->assertFalse($asset->isImage());
    }

    /** @test */
    public function it_can_create_a_thumbnail_for_the_asset()
    {
        Storage::fake();

        $asset = factory(Asset::class)->create([
            'mimetype' => 'image/jpeg',
        ]);

        $asset->createThumbnail();

        $this->assertNotNull($asset->thumb_path);

        Storage::disk()->assertExists($asset->thumb_path);
    }

    /** @test */
    public function it_wont_crete_a_thumbnail_for_a_non_image_asset()
    {
        Storage::fake();

        $asset = factory(Asset::class)->create([
            'mimetype' => 'application/pdf',
        ]);

        $asset->createThumbnail();

        $this->assertNull($asset->thumb_path);
    }

    /** @test */
    public function it_can_upload_a_new_asset()
    {
        Storage::fake();

        $project = factory(Project::class)->create();

        $asset = UploadedFile::fake()->image('test.jpeg');

        $asset = Asset::upload($asset, $project);

        Storage::disk()->assertExists($asset->path);
    }

    /** @test */
    public function it_can_get_the_content_hash_of_an_asset()
    {
        Storage::fake();

        $asset = UploadedFile::fake()->image('test.jpeg');

        $this->assertNotNull(Asset::getContentHash($asset));
    }

    /** @test */
    public function it_can_get_extra_attributes_of_an_image()
    {
        $asset = UploadedFile::fake()->image('test.jpeg');

        $attributes = Asset::getExtraAttributes($asset);

        $this->assertNotNull($attributes['width']);
        $this->assertNotNull($attributes['height']);
    }

    /** @test */
    public function it_can_move_an_asset_to_a_folder()
    {
        $folder1 = factory(AssetFolder::class)->create();
        $folder2 = factory(AssetFolder::class)->create();

        $asset = factory(Asset::class)->create([
            'asset_folder_id' => $folder1->id,
        ]);

        $this->assertCount(1, $folder1->assets);
        $this->assertCount(0, $folder2->assets);

        $asset->moveTo($folder2);

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'asset_folder_id' => $folder2->id,
        ]);
    }
}
