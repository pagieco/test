<?php

namespace Tests\Feature\Api\Asset;

use Tests\TestCase;
use App\Models\Asset;
use Illuminate\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetAssetsControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_returns_an_empty_response_when_no_assets_where_found()
    {
        $this->login()->forceAccess($this->role, 'asset:list');

        $this->makeRequest()->assertSchema('GetAssets', Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function it_doesnt_include_assets_from_other_projects()
    {
        $this->login()->forceAccess($this->role, 'asset:list');

        factory(Asset::class)->create([
            'project_id' => $this->project,
        ]);

        factory(Asset::class)->create();

        $response = $this->makeRequest();

        $this->assertCount(1, $response->json('data'));
    }

    /** @test */
    public function it_throws_403_forbidden_exception_when_the_user_has_no_access_to_list_the_assets()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetAssets', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_successfully_executes_the_get_assets_route()
    {
        $this->login()->forceAccess($this->role, 'asset:list');

        factory(Asset::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest()->assertSchema('GetAssets', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(): TestResponse
    {
        return $this->get(route('get-assets'));
    }
}
