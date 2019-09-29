<?php

namespace Tests\Feature\Api\Profile;

use Tests\TestCase;
use App\Http\Response;
use App\Models\Profile;
use App\Models\ProfileEvent;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetProfileEventsControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_profile_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetProfileEvents', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_profile()
    {
        $this->login();

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($profile->external_id)->assertSchema('GetProfileEvents', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_profile_exists_but_is_not_part_of_the_current_profile()
    {
        $this->login();

        $profile = factory(Profile::class)->create();

        $this->makeRequest($profile->external_id)->assertSchema('GetProfileEvents', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_returns_an_empty_response_when_no_events_where_found()
    {
        $this->login()->forceAccess($this->role, 'profile:list-events');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($profile->external_id)->assertSchema('GetProfileEvents', Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function it_doesnt_include_event_from_other_profiles()
    {
        $this->login()->forceAccess($this->role, 'profile:list-events');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        factory(ProfileEvent::class)->create([
            'profile_id' => $profile->local_id,
            'project_id' => $profile->project_id,
        ]);

        factory(ProfileEvent::class)->create();

        $this->assertCount(1, $this->makeRequest($profile->external_id)->json('data'));
    }

    /** @test */
    public function it_successfully_executes_the_get_profile_events_route()
    {
        $this->login()->forceAccess($this->role, 'profile:list-events');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        factory(ProfileEvent::class)->create([
            'profile_id' => $profile->local_id,
            'project_id' => $profile->project_id,
        ]);

        $this->makeRequest($profile->external_id)->assertSchema('GetProfileEvents', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->get(route('get-profile-events', $id ?? faker()->numberBetween(1)));
    }
}
