<?php

namespace Tests\Feature\Domains\Form;

use Tests\TestCase;
use App\Http\Response;
use App\Domains\Form\Models\Form;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetFormControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_form_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetForm', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_form()
    {
        $this->login();

        $form = factory(Form::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($form->id)->assertSchema('GetForm', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_form_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $form = factory(Form::class)->create();

        $this->makeRequest($form->id)->assertSchema('GetForm', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_successfully_executes_the_get_form_route()
    {
        $this->login()->forceAccess($this->role, 'form:view');

        $form = factory(Form::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($form->id)->assertSchema('GetForm', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->get(route('get-form', $id ?? faker()->numberBetween(1)));
    }
}
