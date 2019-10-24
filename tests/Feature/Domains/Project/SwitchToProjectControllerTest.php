<?php

namespace Tests\Feature\Domains\Project;

use Tests\TestCase;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use App\Domains\Project\Models\Project;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SwitchToProjectControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_project_could_not_be_found()
    {
        $this->login()->forceAccess($this->role, 'project:switch');

        $this->makeRequest()->assertSchema('SwitchToProject', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_project()
    {
        $this->login()->forceAccess($this->role, 'project:switch');

        $project = factory(Project::class)->create();

        $this->makeRequest($project->id)->assertSchema('SwitchToProject', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_successfully_executes_the_switch_to_project_route()
    {
        $this->login()->forceAccess($this->role, 'project:switch');

        $this->makeRequest($this->project->id)->assertSchema('SwitchToProject', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->post(route('switch-to-project', $id ?? faker()->numberBetween(1)));
    }
}
