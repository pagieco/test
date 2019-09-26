<?php

namespace Tests\Feature\Api\Profile;

use Tests\TestCase;
use App\Models\Profile;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetProfileControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_profile_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetProfile', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_profile()
    {
        $this->login();

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($profile->external_id)->assertSchema('GetProfile', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_profile_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $profile = factory(Profile::class)->create();

        $this->makeRequest($profile->external_id)->assertSchema('GetProfile', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_successfully_executes_the_get_profile_route()
    {
        $this->login()->forceAccess($this->role, 'profile:view');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($profile->external_id)->assertSchema('GetProfile', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->get(route('get-profile', $id ?? faker()->numberBetween(1)));
    }
}
