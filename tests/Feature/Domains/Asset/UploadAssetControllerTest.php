<?php

namespace Tests\Feature\Domains\Asset;

use Tests\TestCase;
use App\Http\Response;
use Illuminate\Http\UploadedFile;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Support\Facades\Storage;
use App\Domains\Asset\Models\AssetFolder;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadAssetControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_validates_on_a_required_asset_when_uploading_an_asset()
    {
        $this->login();

        $this->makeRequest()->assertSchema('UploadAsset', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_validates_on_valid_file_when_uploading_an_asset()
    {
        $this->login();

        $this->makeRequest(['asset' => 'my-file'])->assertSchema('UploadAsset', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_is_not_allowed_to_upload_an_asset()
    {
        Storage::fake();

        $this->login();

        $data = ['asset' => UploadedFile::fake()->image('avatar.jpeg')];

        $this->makeRequest($data)->assertSchema('UploadAsset', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_successfully_executes_the_upload_asset_route()
    {
        Storage::fake();

        $this->login()->forceAccess($this->role, 'asset:upload');

        $data = ['asset' => UploadedFile::fake()->image('avatar.jpeg')];

        $response = $this->makeRequest($data);

        $response->assertSchema('UploadAsset', Response::HTTP_CREATED);

        $this->assertDatabaseHas('assets', [
            'external_id' => $response->json('data.id'),
        ]);

        Storage::assertExists($response->json('data.path'));
    }

    /** @test */
    public function it_can_upload_an_asset_to_a_folder()
    {
        Storage::fake();

        $user = $this->login();

        $user->forceAccess($this->role, 'asset:upload', 'asset-folder:view');

        $folder = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $data = [
            'asset' => UploadedFile::fake()->image('avatar.jpeg'),
            'folder_id' => $folder->external_id,
        ];

        $response = $this->makeRequest($data);

        $response->assertSchema('UploadAsset', Response::HTTP_CREATED);

        $this->assertDatabaseHas('assets', [
            'external_id' => $response->json('data.id'),
            'asset_folder_id' => $folder->id,
        ]);

        Storage::assertExists($response->json('data.path'));
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(array $data = []): TestResponse
    {
        return $this->post(route('upload-asset'), $data);
    }
}
