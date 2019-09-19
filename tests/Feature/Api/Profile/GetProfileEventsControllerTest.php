<?php

namespace Tests\Feature\Api\Profile;

use Tests\TestCase;
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
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_profile()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_profile_exists_but_is_not_part_of_the_current_profile()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_returns_an_empty_response_when_no_events_where_found()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_doesnt_include_event_from_other_profiles()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_successfully_executes_the_get_profile_events_route()
    {
        $this->markTestIncomplete();
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->get(route('get-profile-events', $id ?? faker()->randomNumber()));
    }
}
