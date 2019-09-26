<?php

namespace Tests\Feature\Api\AssetFolder;

use Tests\TestCase;
use App\Http\Response;
use App\Models\AssetFolder;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateAssetFolderControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_asset_folder_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('UpdateAssetFolder', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_asset_folder()
    {
        $this->login();

        $folder = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($folder->external_id)->assertSchema('UpdateAssetFolder', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_asset_folder_exists_but_is_not_part_of_the_project()
    {
        $this->login()->forceAccess($this->role, 'asset-folder:update');

        $folder = factory(AssetFolder::class)->create();

        $this->makeRequest($folder->external_id)->assertSchema('UpdateAssetFolder', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_exists_but_is_empty_when_updating_the_asset_folder()
    {
        $this->login()->forceAccess($this->role, 'asset-folder:update');

        $folder = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($folder->external_id, [
            'name' => '',
        ])->assertSchema('UpdateAssetFolder', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_short_when_updating_the_asset_folder()
    {
        $this->login()->forceAccess($this->role, 'asset-folder:update');

        $folder = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($folder->external_id, [
            'name' => 'a',
        ])->assertSchema('UpdateAssetFolder', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_long_when_updating_the_asset_folder()
    {
        $this->login()->forceAccess($this->role, 'asset-folder:update');

        $folder = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($folder->external_id, [
            'name' => str_repeat('a', 251),
        ])->assertSchema('UpdateAssetFolder', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_description_exists_but_is_empty_when_updating_the_asset_folder()
    {
        $this->login()->forceAccess($this->role, 'asset-folder:update');

        $folder = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($folder->external_id, [
            'description' => '',
        ])->assertSchema('UpdateAssetFolder', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_description_is_too_short_when_updating_the_asset_folder()
    {
        $this->login()->forceAccess($this->role, 'asset-folder:update');

        $folder = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($folder->external_id, [
            'description' => 'a',
        ])->assertSchema('UpdateAssetFolder', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_description_is_too_long_when_updating_the_asset_folder()
    {
        $this->login()->forceAccess($this->role, 'asset-folder:update');

        $folder = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($folder->external_id, [
            'description' => str_repeat('a', 251),
        ])->assertSchema('UpdateAssetFolder', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_successfully_executes_the_update_asset_folder_request()
    {
        $this->login()->forceAccess($this->role, 'asset-folder:update');

        $folder = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($folder->external_id, [
            'description' => 'My test description',
        ])->assertSchema('UpdateAssetFolder', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @param  array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null, array $data = []): TestResponse
    {
        return $this->patch(route('update-asset-folder', $id ?? faker()->numberBetween(1)), $data);
    }
}
