<?php

namespace Tests\Feature\Domains\Asset;

use Tests\TestCase;
use App\Http\Response;
use App\Domains\Asset\Models\Asset;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetAssetControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_asset_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetAsset', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_asset()
    {
        $this->login();

        $asset = factory(Asset::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($asset->external_id)->assertSchema('GetAsset', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_asset_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $asset = factory(Asset::class)->create();

        $this->makeRequest($asset->external_id)->assertSchema('GetAsset', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_successfully_executes_the_get_asset_route()
    {
        $this->login()->forceAccess($this->role, 'asset:view');

        $asset = factory(Asset::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($asset->external_id)->assertSchema('GetAsset', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->get(route('get-asset', $id ?? faker()->numberBetween(1)));
    }
}
