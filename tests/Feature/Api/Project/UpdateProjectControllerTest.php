<?php

namespace Tests\Feature\Api\Project;

use Tests\TestCase;
use App\Http\Response;
use App\Models\Project;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateProjectControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_project_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('UpdateProject', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_project()
    {
        $this->login();

        $this->makeRequest($this->project->id)->assertSchema('UpdateProject', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_exists_but_is_empty_when_updating_the_project()
    {
        $this->login()->forceAccess($this->role, 'project:update');

        $this->makeRequest($this->project->id, [
            'name' => ''
        ])->assertSchema('UpdateProject', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_short_when_updating_the_project()
    {
        $this->login()->forceAccess($this->role, 'project:update');

        $this->makeRequest($this->project->id, [
            'name' => 'a'
        ])->assertSchema('UpdateProject', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_long_when_updating_the_project()
    {
        $this->login()->forceAccess($this->role, 'project:update');

        $this->makeRequest($this->project->id, [
            'name' => str_repeat('a', 101),
        ])->assertSchema('UpdateProject', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_already_used_when_updating_the_project()
    {
        $this->login()->forceAccess($this->role, 'project:update');

        $project = factory(Project::class)->create();

        $this->makeRequest($this->project->id, [
            'name' => $project->name,
        ])->assertSchema('UpdateProject', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_successfully_executes_the_update_project_route()
    {
        $this->login()->forceAccess($this->role, 'project:update');

        $this->makeRequest($this->project->id, [
            'name' => faker()->domainWord,
        ])->assertSchema('UpdateProject', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @param  array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null, array $data = []): TestResponse
    {
        return $this->patch(route('update-project', $id ?? faker()->numberBetween(1)), $data);
    }
}
