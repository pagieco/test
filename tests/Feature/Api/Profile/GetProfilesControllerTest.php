<?php

namespace Tests\Feature\Api\Profile;

use Tests\TestCase;
use App\Http\Response;
use App\Models\Profile;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetProfilesControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_returns_an_empty_response_when_no_profiles_where_found()
    {
        $this->login()->forceAccess($this->role, 'profile:list');

        $this->makeRequest()->assertSchema('GetProfiles', Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function it_doesnt_include_profiles_from_other_projects()
    {
        $this->login()->forceAccess($this->role, 'profile:list');

        factory(Profile::class)->create([
            'project_id' => $this->project,
        ]);

        factory(Profile::class)->create();

        $this->assertCount(1, $this->makeRequest()->json('data'));
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_profiles()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetProfiles', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_successfully_executes_the_get_profiles_route()
    {
        $this->login()->forceAccess($this->role, 'profile:list');

        factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest()->assertSchema('GetProfiles', Response::HTTP_OK);
    }

    /** @test */
    public function it_returns_a_paginatable_response()
    {
        $this->login()->forceAccess($this->role, 'profile:list');

        factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertNotNull($this->makeRequest()->json('data'));
        $this->assertNotNull($this->makeRequest()->json('links'));
        $this->assertNotNull($this->makeRequest()->json('meta'));
    }

    /** @test */
    public function it_returns_a_sortable_response()
    {
        $this->login()->forceAccess($this->role, 'profile:list');

        $profile1 = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $profile2 = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest(['sort' => '-id']);

        $this->assertEquals($profile2->external_id, $response->json('data.0.id'));
        $this->assertEquals($profile1->external_id, $response->json('data.1.id'));
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  array $parameters
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(array $parameters = []): TestResponse
    {
        return $this->get(route('get-profiles', $parameters));
    }
}
