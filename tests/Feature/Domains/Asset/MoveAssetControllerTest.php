<?php

namespace Tests\Feature\Domains\Asset;

use Tests\TestCase;
use App\Http\Response;
use App\Domains\Asset\Models\Asset;
use Tests\Feature\AuthenticatedRoute;
use App\Domains\Asset\Models\AssetFolder;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MoveAssetControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_asset_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('MoveAsset', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_requires_the_folder_id_when_moving_an_asset()
    {
        $this->login();

        $folder1 = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $asset = factory(Asset::class)->create([
            'project_id' => $this->project->id,
            'asset_folder_id' => $folder1->id,
        ]);

        $this->makeRequest($asset->external_id)->assertSchema('MoveAsset', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_asset()
    {
        $this->login();

        $folder1 = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $folder2 = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $asset = factory(Asset::class)->create([
            'project_id' => $this->project->id,
            'asset_folder_id' => $folder1->local_id,
        ]);

        $this->makeRequest($asset->external_id, [
            'folder_id' => $folder2->external_id,
        ])->assertSchema('MoveAsset', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_folder()
    {
        $this->login();

        $folder1 = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $folder2 = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $asset = factory(Asset::class)->create([
            'project_id' => $this->project->id,
            'asset_folder_id' => $folder1->local_id,
        ]);

        $this->makeRequest($asset->external_id, [
            'folder_id' => $folder2->external_id,
        ])->assertSchema('MoveAsset', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_folder_could_not_be_found()
    {
        $this->login()->forceAccess($this->role, 'asset:move');

        $folder1 = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $folder2 = factory(AssetFolder::class)->create();

        $asset = factory(Asset::class)->create([
            'project_id' => $this->project->id,
            'asset_folder_id' => $folder1->id,
        ]);

        $this->makeRequest($asset->id, [
            'folder_id' => $folder2->id,
        ])->assertSchema('MoveAsset', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_asset_exists_but_is_not_part_of_the_project()
    {
        $this->login()->forceAccess($this->role, 'asset:move');

        $folder1 = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $folder2 = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $asset = factory(Asset::class)->create([
            'asset_folder_id' => $folder1->id,
        ]);

        $this->makeRequest($asset->id, [
            'folder_id' => $folder2->id,
        ])->assertSchema('MoveAsset', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_successfully_executes_the_move_asset_route()
    {
        $this->login()->forceAccess($this->role, 'asset-folder:view', 'asset:move');

        $folder1 = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $folder2 = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $asset = factory(Asset::class)->create([
            'project_id' => $this->project->id,
            'asset_folder_id' => $folder1->local_id,
        ]);

        $this->makeRequest($asset->external_id, [
            'folder_id' => $folder2->external_id,
        ])->assertSchema('MoveAsset', Response::HTTP_CREATED);
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
        return $this->put(route('move-asset', $id ?? faker()->numberBetween(1)), $data);
    }
}
