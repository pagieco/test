<?php

namespace Tests\Feature\Api\Automation;

use Tests\TestCase;
use App\Models\Automation;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetAutomationControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_automation_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetAutomation', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_automation()
    {
        $this->login();

        $automation = factory(Automation::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($automation->id)->assertSchema('GetAutomation', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_automation_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $automation = factory(Automation::class)->create();

        $this->makeRequest($automation->id)->assertSchema('GetAutomation', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_successfully_executes_the_get_automation_route()
    {
        $this->login()->forceAccess($this->role, 'automation:view');

        $automation = factory(Automation::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($automation->id)->assertSchema('GetAutomation', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->get(route('get-automation', $id ?? faker()->randomNumber()));
    }
}
