<?php

namespace Tests\Unit\Models\Observers;

use Tests\TestCase;
use Ramsey\Uuid\Uuid;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectObserverTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_project_hash_when_the_creating_event_is_triggered()
    {
        $project = factory(Project::class)->create();

        $this->assertTrue(Uuid::isValid($project->hash));
    }

    /** @test */
    public function it_creates_a_new_domain_when_the_created_event_is_triggered()
    {
        $project = factory(Project::class)->create();

        $this->assertCount(1, $project->domains);
    }

    /** @test */
    public function it_creates_a_new_homepage_when_the_created_event_is_triggered()
    {
        $project = factory(Project::class)->create();

        $this->assertCount(1, $project->domains->first()->pages);
    }
}
