<?php

namespace Tests\Unit\Domains\Workflow\Policies;

use Tests\Unit\Policies\PolicyTestCase;
use App\Domains\Workflow\Models\Workflow;
use App\Domains\Workflow\Policies\WorkflowPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkflowPolicyTest extends PolicyTestCase
{
    use RefreshDatabase;

    /**
     * The policy implementation.
     *
     * @var string
     */
    protected $policy = WorkflowPolicy::class;

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_list_the_workflows()
    {
        $user = $this->login();

        $this->assertFalse((new WorkflowPolicy)->list($user));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_list_the_workflows()
    {
        $user = tap($this->login())->forceAccess($this->role, 'workflow:list');

        $this->assertTrue((new WorkflowPolicy)->list($user));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_view_a_workflow()
    {
        $user = $this->login();

        $workflow = factory(Workflow::class)->create();

        $this->assertFalse((new WorkflowPolicy)->view($user, $workflow));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_view_a_workflow_but_the_workflow_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'workflow:view');

        $workflow = factory(Workflow::class)->create();

        $this->assertFalse((new WorkflowPolicy)->view($user, $workflow));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_view_the_workflow()
    {
        $user = tap($this->login())->forceAccess($this->role, 'workflow:view');

        $workflow = factory(Workflow::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new WorkflowPolicy)->view($user, $workflow));
    }
}
