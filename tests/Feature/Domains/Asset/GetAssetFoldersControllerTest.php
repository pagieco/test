<?php

namespace Tests\Feature\Domains\Asset;

use Tests\TestCase;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use App\Domains\Asset\Models\AssetFolder;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetAssetFoldersControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_returns_an_empty_response_when_no_folders_where_found()
    {
        $this->login()->forceAccess($this->role, 'asset-folder:list');

        $this->makeRequest()->assertSchema('GetAssetFolders', Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function it_doesnt_include_folders_from_other_projects()
    {
        $this->login()->forceAccess($this->role, 'asset-folder:list');

        factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        factory(AssetFolder::class)->create();

        $this->assertCount(1, $this->makeRequest()->json('data'));
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_list_of_folders()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetAssetFolders', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_successfully_executes_the_get_asset_folders_route()
    {
        $this->login()->forceAccess($this->role, 'asset-folder:list');

        factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest()->assertSchema('GetAssetFolders', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(): TestResponse
    {
        return $this->get(route('get-asset-folders'));
    }
}
