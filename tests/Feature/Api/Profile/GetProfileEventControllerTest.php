<?php

namespace Tests\Feature\Api\Profile;

use Tests\TestCase;
use App\Http\Response;
use App\Models\Profile;
use App\Models\ProfileEvent;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetProfileEventControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_event_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetProfileEvent', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_event()
    {
        $this->login();

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $event = factory(ProfileEvent::class)->create([
            'profile_id' => $profile->id,
        ]);

        $this->makeRequest($event->id)->assertSchema('GetProfileEvent', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_event_exists_but_is_not_part_of_the_project()
    {
        $this->login()->forceAccess($this->role, 'profile:view-event');

        $event = factory(ProfileEvent::class)->create([
            'profile_id' => factory(Profile::class)->create()->id,
        ]);

        $this->makeRequest($event->id)->assertSchema('GetProfileEvent', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_successfully_executes_the_get_profile_event_route()
    {
        $this->login()->forceAccess($this->role, 'profile:view-event');

        $event = factory(ProfileEvent::class)->create([
            'profile_id' => factory(Profile::class)->create([
                'project_id' => $this->project->id,
            ])->id,
        ]);

        $this->makeRequest($event->id)->assertSchema('GetProfileEvent', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->get(route('get-profile-event', $id ?? faker()->randomNumber()));
    }
}
