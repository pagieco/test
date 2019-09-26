<?php

namespace Tests\Feature\Api\Form;

use Tests\TestCase;
use App\Models\Form;
use App\Http\Response;
use App\Models\FormSubmission;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetFormSubmissionControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_submission_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetFormSubmission', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_submission()
    {
        $this->login();

        $form = factory(Form::class)->create([
            'project_id' => $this->project->id,
        ]);

        $submission = factory(FormSubmission::class)->create([
            'form_id' => $form->id,
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($submission->id)->assertSchema('GetFormSubmission', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_form_exists_but_is_not_part_of_the_project()
    {
        $this->login()->forceAccess($this->role, 'form:view-submission');

        $submission = factory(FormSubmission::class)->create([
            'form_id' => factory(Form::class)->create()->id,
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($submission->id)->assertSchema('GetFormSubmission', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_successfully_executes_the_get_form_submissions_route()
    {
        $this->login()->forceAccess($this->role, 'form:view-submission');

        $submission = factory(FormSubmission::class)->create([
            'project_id' => $this->project->id,
            'form_id' => factory(Form::class)->create([
                'project_id' => $this->project->id,
            ])->id,
        ]);

        $this->makeRequest($submission->id)->assertSchema('GetFormSubmission', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->get(route('get-form-submission', $id ?? faker()->numberBetween(1)));
    }
}
