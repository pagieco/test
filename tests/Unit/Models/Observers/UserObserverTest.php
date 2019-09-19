<?php

namespace Tests\Unit\Models\Observers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserObserverTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_personal_project_when_the_created_event_is_triggered()
    {
        $user = factory(User::class)->create();

        $this->assertCount(1, $user->projects);
        $this->assertEquals('Personal', $user->projects->first()->name);
    }
}
