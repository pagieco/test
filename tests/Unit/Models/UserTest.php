<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
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
    public function it_can_access_a_project_the_user_has_access_to_or_is_shared_with_the_user()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_cannot_access_a_project_the_user_has_no_access_to_or_is_not_shared_with_the_user()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_can_get_the_current_project()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_can_switch_to_a_project()
    {
        $this->markTestIncomplete();
    }
}
