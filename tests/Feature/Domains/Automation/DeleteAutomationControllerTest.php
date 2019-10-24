<?php

namespace Tests\Feature\Domains\Automation;

use Tests\TestCase;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use App\Domains\Automation\Models\Automation;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteAutomationControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_automation_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('DeleteAutomation', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_delete_the_automation()
    {
        $this->login();

        $automation = factory(Automation::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($automation->id)->assertSchema('DeleteAutomation', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_automation_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $automation = factory(Automation::class)->create();

        $this->makeRequest($automation->id)->assertSchema('DeleteAutomation', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_can_successfully_execute_the_delete_automation_route()
    {
        $this->login()->forceAccess($this->role, 'automation:delete');

        $automation = factory(Automation::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($automation->id)->assertSchema('DeleteAutomation', Response::HTTP_NO_CONTENT);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->delete(route('delete-automation', $id ?? faker()->numberBetween(1)));
    }
}
