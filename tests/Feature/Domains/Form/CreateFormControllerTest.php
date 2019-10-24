<?php

namespace Tests\Feature\Domains\Form;

use Tests\TestCase;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use App\Domains\Form\Enums\FormFieldType;
use App\Domains\Form\Enums\FormFieldValidation;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateFormControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_permission_to_create_a_new_form()
    {
        $this->login();

        $this->makeRequest([
            'name' => faker()->name,
            'fields' => [
                'my-field' => [
                    'slug' => 'my-field',
                    'display_name' => 'My Field',
                    'type' => FormFieldType::PlainText,
                    'validations' => [
                        FormFieldValidation::Required => true,
                    ],
                ],
            ],
        ])->assertSchema('CreateForm', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_missing_when_creating_a_new_form()
    {
        $this->login();

        $response = $this->makeRequest([
            'name' => null,
        ]);

        $this->assertEquals($response->json('errors.name.0'), 'The name field is required.');

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_short_when_creating_a_new_form()
    {
        $this->login();

        $response = $this->makeRequest([
            'name' => 'a',
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.name.0'), 'The name must be at least 3 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_long_when_creating_a_new_form()
    {
        $this->login();

        $response = $this->makeRequest([
            'name' => str_repeat('a', 101),
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.name.0'), 'The name may not be greater than 100 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_description_is_too_long_when_creating_a_new_form()
    {
        $this->login();

        $response = $this->makeRequest([
            'description' => str_repeat('a', 251),
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.description.0'), 'The description may not be greater than 250 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_fields_array_is_missing_when_creating_a_new_form()
    {
        $this->login();

        $response = $this->makeRequest();

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.fields.0'), 'The fields field is required.');
    }

    /** @test */
    public function it_throws_a_422_when_the_display_name_key_is_missing_on_the_fields_array_when_creating_a_new_form()
    {
        $this->login();

        $response = $this->makeRequest([
            'fields' => [
                'test-field' => '',
            ],
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors')['fields.test-field.display_name'][0], 'The fields.test-field.display_name field is required.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_display_name_is_too_short_when_creating_a_new_form()
    {
        $this->login();

        $response = $this->makeRequest([
            'fields' => [
                'test-field' => [
                    'display_name' => 'a',
                ],
            ],
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors')['fields.test-field.display_name'][0], 'The fields.test-field.display_name must be at least 3 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_display_name_is_too_long_when_creating_a_new_form()
    {
        $this->login();

        $response = $this->makeRequest([
            'fields' => [
                'test-field' => [
                    'display_name' => str_repeat('a', 101),
                ],
            ],
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors')['fields.test-field.display_name'][0], 'The fields.test-field.display_name may not be greater than 100 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_is_missing_in_the_fields_array_when_creating_a_new_form()
    {
        $this->login();

        $response = $this->makeRequest([
            'fields' => [
                'test-field' => [
                    'slug' => '',
                ],
            ],
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors')['fields.test-field.slug'][0], 'The fields.test-field.slug field is required.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_is_too_short_when_creating_a_new_form()
    {
        $this->login();

        $response = $this->makeRequest([
            'fields' => [
                'test-field' => [
                    'slug' => 'a',
                ],
            ],
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors')['fields.test-field.slug'][0], 'The fields.test-field.slug must be at least 3 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_is_too_long_when_creating_a_new_form()
    {
        $this->login();

        $response = $this->makeRequest([
            'fields' => [
                'test-field' => [
                    'slug' => str_repeat('a', 251),
                ],
            ],
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors')['fields.test-field.slug'][0], 'The fields.test-field.slug may not be greater than 100 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_contains_characters_other_than_alpha_dash_when_creating_a_new_form()
    {
        $this->login();

        $response = $this->makeRequest([
            'fields' => [
                'test-field' => [
                    'slug' => 'test value',
                ],
            ],
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors')['fields.test-field.slug'][0], 'The fields.test-field.slug may only contain letters, numbers, dashes and underscores.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_field_type_is_not_valid_when_creating_a_new_form()
    {
        $this->login();

        $response = $this->makeRequest([
            'fields' => [
                'test-field' => [
                    'type' => 'wrong-field-type',
                ],
            ],
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors')['fields.test-field.type'][0], 'The selected fields.test-field.type is invalid.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_validations_field_is_not_an_array_when_creating_a_new_form()
    {
        $this->login();

        $response = $this->makeRequest([
            'fields' => [
                'test-field' => [
                    'validations' => 'wrong-field-validations-type',
                ],
            ],
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors')['fields.test-field.validations'][0], 'The fields.test-field.validations must be an array.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_a_validation_type_does_not_exists_when_creating_a_new_form()
    {
        $this->login();

        $response = $this->makeRequest([
            'fields' => [
                'test-field' => [
                    'validations' => [
                        'wrong-field-validations-type' => true,
                    ],
                ],
            ],
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors')['fields.test-field.validations'][0], 'Invalid validation rule.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_no_profile_identifiers_are_present_when_creating_a_new_form()
    {
        $this->login()->forceAccess($this->role, 'form:create');

        $response = $this->makeRequest([
            'name' => faker()->name,
            'fields' => [
                'test-field' => [
                    'slug' => 'my-field',
                    'display_name' => 'My Field',
                    'type' => FormFieldType::Email,
                    'is_profile_identifier' => false,
                    'validations' => [
                        FormFieldValidation::Required => true,
                    ],
                ],
                'other-field' => [
                    'slug' => 'my-field',
                    'display_name' => 'My Field',
                    'type' => FormFieldType::Email,
                    'is_profile_identifier' => false,
                    'validations' => [
                        FormFieldValidation::Required => true,
                    ],
                ],
            ],
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors')['profile-identifier'][0], 'A profile identifier field is required.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_more_then_one_profile_identifiers_are_present_when_creating_a_new_form()
    {
        $this->login()->forceAccess($this->role, 'form:create');

        $response = $this->makeRequest([
            'name' => faker()->name,
            'fields' => [
                'test-field' => [
                    'slug' => 'my-field',
                    'display_name' => 'My Field',
                    'type' => FormFieldType::Email,
                    'is_profile_identifier' => true,
                    'validations' => [
                        FormFieldValidation::Required => true,
                    ],
                ],
                'other-field' => [
                    'slug' => 'my-field',
                    'display_name' => 'My Field',
                    'type' => FormFieldType::Email,
                    'is_profile_identifier' => true,
                    'validations' => [
                        FormFieldValidation::Required => true,
                    ],
                ],
            ],
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors')['profile-identifier'][0], 'Only one profile identifier field can be present per form.');
    }

    /** @test */
    public function it_successfully_executes_the_create_form_route()
    {
        $this->login()->forceAccess($this->role, 'form:create');

        $response = $this->makeRequest([
            'name' => faker()->name,
            'fields' => [
                'test-field' => [
                    'slug' => 'my-field',
                    'display_name' => 'My Field',
                    'type' => FormFieldType::Email,
                    'is_profile_identifier' => true,
                    'validations' => [
                        FormFieldValidation::Required => true,
                    ],
                ],
                'other-field' => [
                    'slug' => 'my-field',
                    'display_name' => 'My Field',
                    'type' => FormFieldType::Email,
                    'validations' => [
                        FormFieldValidation::Required => true,
                    ],
                ],
            ],
        ]);

        $response->assertSchema('CreateForm', Response::HTTP_CREATED);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(array $data = []): TestResponse
    {
        return $this->post(route('create-form'), $data);
    }
}
