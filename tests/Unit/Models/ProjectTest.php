<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Events\ProjectShared;
use App\Events\ProjectUnshared;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_many_assets()
    {
        $this->assertInstanceOf(HasMany::class, app(Project::class)->assets());
    }

    /** @test */
    public function it_has_many_asset_folders()
    {
        $this->assertInstanceOf(HasMany::class, app(Project::class)->assetFolders());
    }

    /** @test */
    public function it_has_many_automations()
    {
        $this->assertInstanceOf(HasMany::class, app(Project::class)->automations());
    }

    /** @test */
    public function it_belongs_to_many_collaborators()
    {
        $this->assertInstanceOf(BelongsToMany::class, app(Project::class)->collaborators());
    }

    /** @test */
    public function it_has_many_collections()
    {
        $this->assertInstanceOf(HasMany::class, app(Project::class)->collections());
    }

    /** @test */
    public function it_has_many_domains()
    {
        $this->assertInstanceOf(HasMany::class, app(Project::class)->domains());
    }

    /** @test */
    public function it_has_many_emails()
    {
        $this->assertInstanceOf(HasMany::class, app(Project::class)->emails());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $this->assertInstanceOf(BelongsTo::class, app(Project::class)->owner());
    }

    /** @test */
    public function it_has_many_forms()
    {
        $this->assertInstanceOf(HasMany::class, app(Project::class)->forms());
    }

    /** @test */
    public function it_has_many_pages()
    {
        $this->assertInstanceOf(HasMany::class, app(Project::class)->pages());
    }

    /** @test */
    public function it_has_many_workflows()
    {
        $this->assertInstanceOf(HasMany::class, app(Project::class)->workflows());
    }

    /** @test */
    public function it_can_insert_a_new_record()
    {
        $this->assertDatabaseHas('projects', [
            'id' => factory(Project::class)->create()->id,
        ]);
    }

    /** @test */
    public function it_can_be_shared_with_a_user()
    {
        Event::fake();

        $project = factory(Project::class)->create();

        $user = factory(User::class)->create();

        $project->shareWith($user);

        Event::assertDispatched(ProjectShared::class, function ($event) use ($project, $user) {
            return $event->project->id === $project->id
                && $event->user->id === $user->id;
        });
    }

    /** @test */
    public function it_can_stop_sharing_with_a_user()
    {
        Event::fake();

        $project = factory(Project::class)->create();

        $user = factory(User::class)->create();

        $project->stopSharingWith($user);

        Event::assertDispatched(ProjectUnshared::class, function ($event) use ($project, $user) {
            return $event->project->id === $project->id
                && $event->user->id === $user->id;
        });
    }

    /** @test */
    public function it_can_generate_a_new_api_token()
    {
        $token = Project::generateApiToken();

        $this->assertEquals(60, strlen($token));
    }
}
