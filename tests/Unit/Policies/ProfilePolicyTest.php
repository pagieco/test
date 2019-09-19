<?php

namespace Tests\Unit\Policies;

use App\Models\Profile;
use App\Models\ProfileEvent;
use App\Policies\ProfilePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilePolicyTest extends PolicyTestCase
{
    use RefreshDatabase;

    /**
     * The policy implementation.
     *
     * @var string
     */
    protected $policy = ProfilePolicy::class;

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_list_the_profiles()
    {
        $user = $this->login();

        $this->assertFalse((new ProfilePolicy)->list($user));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_list_the_profiles()
    {
        $user = tap($this->login())->forceAccess($this->role, 'profile:list');

        $this->assertTrue((new ProfilePolicy)->list($user));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_view_a_profile()
    {
        $user = $this->login();

        $profile = factory(Profile::class)->create();

        $this->assertFalse((new ProfilePolicy)->view($user, $profile));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_view_a_profile_but_the_profile_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'profile:view');

        $profile = factory(Profile::class)->create();

        $this->assertFalse((new ProfilePolicy)->view($user, $profile));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_view_the_profile()
    {
        $user = tap($this->login())->forceAccess($this->role, 'profile:view');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new ProfilePolicy)->view($user, $profile));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_delete_a_profile()
    {
        $user = $this->login();

        $profile = factory(Profile::class)->create();

        $this->assertFalse((new ProfilePolicy)->delete($user, $profile));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_delete_a_profile_but_the_profile_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'profile:Delete');

        $profile = factory(Profile::class)->create();

        $this->assertFalse((new ProfilePolicy)->delete($user, $profile));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_delete_the_profile()
    {
        $user = tap($this->login())->forceAccess($this->role, 'profile:Delete');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertFalse((new ProfilePolicy)->delete($user, $profile));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_list_the_events()
    {
        $user = $this->login();

        $profile = factory(Profile::class)->create();

        $this->assertFalse((new ProfilePolicy)->listEvents($user, $profile));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_list_the_events_but_the_profile_is_not_part_of_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'profile:list-events');

        $profile = factory(Profile::class)->create();

        $this->assertFalse((new ProfilePolicy)->listEvents($user, $profile));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_list_the_events()
    {
        $user = tap($this->login())->forceAccess($this->role, 'profile:list-events');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new ProfilePolicy)->listEvents($user, $profile));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_view_an_event()
    {
        $user = $this->login();

        $event = factory(ProfileEvent::class)->create();

        $this->assertFalse((new ProfilePolicy)->viewEvent($user, $event->profile));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_view_an_event_but_the_profile_is_not_part_of_the_current_project()
    {
        $user = $this->login();

        $event = factory(ProfileEvent::class)->create([
            'profile_id' => factory(Profile::class)->create(),
        ]);

        $this->assertFalse((new ProfilePolicy)->viewEvent($user, $event->profile));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_view_an_event()
    {
        $user = $this->login();

        $event = factory(ProfileEvent::class)->create([
            'profile_id' => factory(Profile::class)->create([
                'project_id' => $this->project->id,
            ]),
        ]);

        $this->assertFalse((new ProfilePolicy)->viewEvent($user, $event->profile));
    }
}
