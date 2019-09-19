<?php

namespace Tests\Feature\Api\Workflow;

use Tests\TestCase;
use App\Models\Workflow;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetWorkflowControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_workflow_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetWorkflow', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_workflow()
    {
        $this->login();

        $workflow = factory(Workflow::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($workflow->id)->assertSchema('GetWorkflow', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_workflow_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $workflow = factory(Workflow::class)->create();

        $this->makeRequest($workflow->id)->assertSchema('GetWorkflow', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_successfully_executes_the_get_workflow_route()
    {
        $this->login()->forceAccess($this->role, 'workflow:view');

        $workflow = factory(Workflow::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($workflow->id)->assertSchema('GetWorkflow', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->get(route('get-workflow', $id ?? faker()->randomNumber()));
    }
}
