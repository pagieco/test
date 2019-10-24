<?php

namespace Tests\Feature\Domains\Asset;

use Tests\TestCase;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use App\Domains\Asset\Models\AssetFolder;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetAssetFolderControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_asset_folder_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetAssetFolder', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_asset_folder()
    {
        $this->login();

        $assetFolder = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($assetFolder->external_id)->assertSchema('GetAssetFolder', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_asset_folder_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $assetFolder = factory(AssetFolder::class)->create();

        $this->makeRequest($assetFolder->external_id)->assertSchema('GetAssetFolder', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_successfully_executes_the_get_asset_folder_route()
    {
        $this->login()->forceAccess($this->role, 'asset-folder:view');

        $assetFolder = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($assetFolder->external_id)->assertSchema('GetAssetFolder', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->get(route('get-asset-folder', $id ?? faker()->numberBetween(1)));
    }
}
