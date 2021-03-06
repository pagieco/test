<?php

namespace Tests\Unit\Domains\Project\Policies;

use App\Domains\Project\Models\Project;
use Tests\Unit\Policies\PolicyTestCase;
use App\Domains\Project\Policies\ProjectPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectPolicyTest extends PolicyTestCase
{
    use RefreshDatabase;

    /**
     * The policy implementation.
     *
     * @var string
     */
    protected $policy = ProjectPolicy::class;

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_switch_to_a_project()
    {
        $user = $this->login();

        $project = factory(Project::class)->create();

        $this->assertFalse((new ProjectPolicy)->switch($user, $project));
    }

    /** @test */
    public function it_returns_false_when_the_user_can_switch_to_a_project_but_the_project_is_not_from_the_users_set_of_projects()
    {
        $user = tap($this->login())->forceAccess($this->role, 'project:switch');

        $project = factory(Project::class)->create();

        $this->assertFalse((new ProjectPolicy)->switch($user, $project));
    }

    /** @test */
    public function it_returns_true_when_the_user_can_switch_to_a_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'project:switch');

        $project = factory(Project::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertTrue((new ProjectPolicy)->switch($user, $project));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_update_a_project()
    {
        $user = $this->login();

        $project = factory(Project::class)->create();

        $this->assertFalse((new ProjectPolicy)->update($user, $project));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_update_a_project_but_the_project_is_not_from_the_users_set_of_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'project:update');

        $project = factory(Project::class)->create();

        $this->assertFalse((new ProjectPolicy)->update($user, $project));
    }

    /** @test */
    public function it_returns_true_when_the_user_can_update_a_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'project:update');

        $project = factory(Project::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertTrue((new ProjectPolicy)->update($user, $project));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_view_the_project()
    {
        $user = $this->login();

        $project = factory(Project::class)->create();

        $this->assertFalse((new ProjectPolicy)->view($user, $project));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_view_the_project_but_the_project_is_not_in_the_users_set_of_projects()
    {
        $user = tap($this->login())->forceAccess($this->role, 'project:view');

        $project = factory(Project::class)->create();

        $this->assertFalse((new ProjectPolicy)->view($user, $project));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_view_the_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'project:view');

        $project = factory(Project::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertTrue((new ProjectPolicy)->view($user, $project));
    }
}
