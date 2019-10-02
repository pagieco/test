<?php

namespace Tests\Feature\Api\Form;

use Tests\TestCase;
use App\Models\Form;
use App\Models\User;
use App\Http\Response;
use App\Models\Profile;
use App\Models\FormField;
use App\Models\Enums\FormFieldType;
use Illuminate\Support\Facades\URL;
use App\Models\Enums\FormFieldValidation;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\TestResponse;
use App\Notifications\FormSubmissionNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubmitFormControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_form_could_not_be_found()
    {
        $this->makeRequest()->assertSchema('SubmitForm', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_requires_an_array_of_fields_when_submitting_a_form()
    {
        $form = factory(Form::class)->create();

        factory(FormField::class, 5)->create([
            'form_id' => $form->id,
        ]);

        $this->makeRequest($form->id)->assertSchema('SubmitForm', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_406_not_acceptable_when_the_route_has_no_valid_signature()
    {
        $form = factory(Form::class)->create();

        factory(FormField::class, 5)->create([
            'form_id' => $form->id,
        ]);

        $this->makeRequest($form->id, [
            'fields' => [
                'test-field' => 'test value',
            ],
        ])->assertSchema('SubmitForm', Response::HTTP_NOT_ACCEPTABLE);
    }

    /** @test */
    public function it_throws_a_400_bad_request_when_the_form_has_no_fields()
    {
        $form = factory(Form::class)->create();

        $route = URL::temporarySignedRoute('submit-form', now()->addMinute(), $form);

        $this->post($route, [
            'fields' => [
                'test-field' => 'test value',
            ],
        ])->assertSchema('SubmitForm', Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    public function it_throws_a_422_unprocessable_entity_response_when_the_form_has_validation_errors()
    {
        $form = factory(Form::class)->create();

        factory(FormField::class)->create([
            'form_id' => $form->id,
        ]);

        $route = URL::temporarySignedRoute('submit-form', now()->addMinute(), $form);

        $this->post($route, [
            'fields' => [
                // ...
            ],
        ])->assertSchema('SubmitForm', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_successfully_executes_the_submit_form_route()
    {
        Notification::fake();

        $form = factory(Form::class)->create();
        $user = factory(User::class)->create();

        $form->subscribeToNotifications($user);

        factory(FormField::class)->create([
            'slug' => 'test-field',
            'form_id' => $form->id,
            'type' => FormFieldType::Email,
            'is_profile_identifier' => true,
            'validations' => [FormFieldValidation::Required],
        ]);

        $route = URL::temporarySignedRoute('submit-form', now()->addMinute(), $form);

        $response = $this->post($route, [
            'fields' => [
                'test-field' => 'value',
            ],
        ]);

        $this->assertDatabaseHas('form_submissions', [
            'id' => $response->json('data.id'),
        ]);

        $response->assertSchema('SubmitForm', Response::HTTP_CREATED);

        Notification::assertSentTo($user, FormSubmissionNotification::class);
    }

    /** @test */
    public function it_will_attach_a_profile_id_when_the_form_is_submitted_with_an_email_field()
    {
        $profile = factory(Profile::class)->create();
        $form = factory(Form::class)->create();

        factory(FormField::class)->create([
            'slug' => 'test-field',
            'form_id' => $form->id,
            'type' => FormFieldType::Email,
            'is_profile_identifier' => true,
            'validations' => [FormFieldValidation::Required],
        ]);

        $route = URL::temporarySignedRoute('submit-form', now()->addMinute(), $form);

        $response = $this->post($route, [
            'fields' => [
                'test-field' => $profile->email,
            ],
        ]);

        $this->assertNotNull($response->json('data.profile.profile_id'));
    }

    /** @test */
    public function it_will_create_a_new_profile_when_non_exists_with_the_filled_in_email_address_when_submitting_a_form()
    {
        $form = factory(Form::class)->create();

        factory(FormField::class)->create([
            'slug' => 'test-field',
            'form_id' => $form->id,
            'type' => FormFieldType::Email,
            'is_profile_identifier' => true,
            'validations' => [FormFieldValidation::Required],
        ]);

        $route = URL::temporarySignedRoute('submit-form', now()->addMinute(), $form);

        $email = faker()->email;

        $response = $this->post($route, [
            'fields' => [
                'test-field' => $email,
            ],
        ]);

        $this->assertEquals($email, $response->json('data.profile.email'));
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
        return $this->post(route('submit-form', $id ?? faker()->numberBetween(1)), $data);
    }
}
