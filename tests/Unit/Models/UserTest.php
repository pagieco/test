<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_many_projects()
    {
        $this->assertInstanceOf(HasMany::class, app(User::class)->projects());
    }

    /** @test */
    public function it_belongs_to_many_team_projects()
    {
        $this->assertInstanceOf(BelongsToMany::class, app(User::class)->teamProjects());
    }

    /** @test */
    public function it_can_access_a_project_the_user_is_owner_of()
    {
        $user = factory(User::class)->create();

        $project = $user->projects()->create(
            factory(Project::class)->raw()
        );

        $this->assertTrue($user->canAccessProject($project));
    }

    /** @test */
    public function it_can_access_a_project_that_is_shared_with_the_user()
    {
        $user = factory(User::class)->create();

        $project = factory(Project::class)->create();

        $project->shareWith($user);

        $this->assertTrue($user->canAccessProject($project));
    }

    /** @test */
    public function it_cannot_access_a_project_the_user_has_no_access_to_or_is_not_shared_with_the_user()
    {
        $user = factory(User::class)->create();

        $project = factory(Project::class)->create();

        $this->assertFalse($user->canAccessProject($project));
    }

    /** @test */
    public function it_can_get_the_current_project()
    {
        $user = factory(User::class)->create();

        $this->assertNull($user->current_project_id);

        $this->assertInstanceOf(Project::class, $user->currentProject());

        $this->assertNotNull($user->current_project_id);
    }

    /** @test */
    public function it_can_switch_to_a_project()
    {
        $user = factory(User::class)->create();

        $project = factory(Project::class)->create([
            'user_id' => $user->id,
        ]);

        $user->switchToProject($project);

        $this->assertEquals($project->id, $user->current_project_id);
    }
}
