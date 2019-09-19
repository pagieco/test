<?php

namespace Tests\Feature\Api\Form;

use Tests\TestCase;
use App\Models\Form;
use App\Http\Response;
use App\Models\FormSubmission;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetFormSubmissionsControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_form_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetFormSubmissions', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_form()
    {
        $this->login();

        $form = factory(Form::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($form->id)->assertSchema('GetFormSubmissions', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_form_exists_but_is_not_part_of_the_current_project()
    {
        $this->login();

        $form = factory(Form::class)->create();

        $this->makeRequest($form->id)->assertSchema('GetFormSubmissions', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_returns_an_empty_response_when_no_submissions_where_found()
    {
        $this->login()->forceAccess($this->role, 'form:list-submissions');

        $form = factory(Form::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($form->id)->assertSchema('GetFormSubmissions', Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function it_doesnt_include_submissions_from_other_forms()
    {
        $this->login()->forceAccess($this->role, 'form:list-submissions');

        $form = factory(Form::class)->create([
            'project_id' => $this->project->id,
        ]);

        factory(FormSubmission::class)->create([
            'form_id' => $form->id,
        ]);

        factory(FormSubmission::class)->create();

        $this->assertCount(1, $this->makeRequest($form->id)->json('data'));
    }

    /** @test */
    public function it_successfully_executes_the_get_form_submissions_route()
    {
        $this->login()->forceAccess($this->role, 'form:list-submissions');

        $form = factory(Form::class)->create([
            'project_id' => $this->project->id,
        ]);

        factory(FormSubmission::class)->create([
            'form_id' => $form->id,
        ]);

        $this->makeRequest($form->id)->assertSchema('GetFormSubmissions', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->get(route('get-form-submissions', $id ?? faker()->randomNumber()));
    }
}
