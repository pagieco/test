<?php

namespace Tests\Unit\Domains\Form\Policies;

use App\Domains\Form\Models\Form;
use Tests\Unit\Policies\PolicyTestCase;
use App\Domains\Form\Policies\FormPolicy;
use App\Domains\Form\Models\FormSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormPolicyTest extends PolicyTestCase
{
    use RefreshDatabase;

    /**
     * The policy implementation.
     *
     * @var string
     */
    protected $policy = FormPolicy::class;

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_list_the_forms()
    {
        $user = $this->login();

        $this->assertFalse((new FormPolicy)->list($user));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_list_the_forms()
    {
        $user = tap($this->login())->forceAccess($this->role, 'form:list');

        $this->assertTrue((new FormPolicy)->list($user));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_view_a_form()
    {
        $user = $this->login();

        $form = factory(Form::class)->create();

        $this->assertFalse((new FormPolicy)->view($user, $form));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_view_a_form_but_the_form_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'form:view');

        $form = factory(Form::class)->create();

        $this->assertFalse((new FormPolicy)->view($user, $form));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_view_the_form()
    {
        $user = tap($this->login())->forceAccess($this->role, 'form:view');

        $form = factory(Form::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new FormPolicy)->view($user, $form));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_delete_a_form()
    {
        $user = $this->login();

        $form = factory(Form::class)->create();

        $this->assertFalse((new FormPolicy)->delete($user, $form));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_delete_a_form_but_the_form_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'form:delete');

        $form = factory(Form::class)->create();

        $this->assertFalse((new FormPolicy)->delete($user, $form));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_delete_a_form()
    {
        $user = tap($this->login())->forceAccess($this->role, 'form:delete');

        $form = factory(Form::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new FormPolicy)->delete($user, $form));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_view_the_form_submissions()
    {
        $user = $this->login();

        $form = factory(Form::class)->create();

        $this->assertFalse((new FormPolicy)->listSubmissions($user, $form));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_view_the_form_submissions_but_the_form_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'form:list-submissions');

        $form = factory(Form::class)->create();

        $this->assertFalse((new FormPolicy)->listSubmissions($user, $form));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_view_the_form_submissions()
    {
        $user = tap($this->login())->forceAccess($this->role, 'form:list-submissions');

        $form = factory(Form::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new FormPolicy)->listSubmissions($user, $form));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_view_a_form_submission()
    {
        $user = $this->login();

        $submission = factory(FormSubmission::class)->create();

        $this->assertFalse((new FormPolicy)->listSubmissions($user, $submission->form));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_view_a_form_submission_but_the_form_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'form:view-submission');

        $submission = factory(FormSubmission::class)->create();

        $this->assertFalse((new FormPolicy)->listSubmissions($user, $submission->form));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_view_a_form_submission()
    {
        $user = tap($this->login())->forceAccess($this->role, 'form:view-submission');

        $submission = factory(FormSubmission::class)->create([
            'form_id' => factory(Form::class)->create([
                'project_id' => $this->project->id,
            ]),
        ]);

        $this->assertFalse((new FormPolicy)->listSubmissions($user, $submission->form));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_create_a_new_form()
    {
        $user = $this->login();

        $this->assertFalse((new FormPolicy)->create($user));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_create_a_new_form()
    {
        $user = tap($this->login())->forceAccess($this->role, 'form:create');

        $this->assertTrue((new FormPolicy)->create($user));
    }
}
