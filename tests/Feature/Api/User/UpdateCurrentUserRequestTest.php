<?php

namespace Tests\Feature\Api\User;

use Tests\TestCase;
use App\Models\User;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCurrentUserRequestTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_422_exception_when_the_name_exists_but_is_empty_when_updating_the_current_user()
    {
        $this->login();

        $this->makeRequest([
            'name' => null,
        ])->assertSchema('UpdateCurrentUser', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_short_when_updating_the_current_user()
    {
        $this->login();

        $this->makeRequest([
            'name' => 'a',
        ])->assertSchema('UpdateCurrentUser', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_long_when_updating_the_current_user()
    {
        $this->login();

        $this->makeRequest([
            'name' => str_repeat('a', 251),
        ])->assertSchema('UpdateCurrentUser', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_email_field_is_passed_but_is_empty_when_updating_the_current_user()
    {
        $this->login();

        $this->makeRequest([
            'email' => null,
        ])->assertSchema('UpdateCurrentUser', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_email_is_not_a_valid_email_address_when_updating_the_current_user()
    {
        $this->login();

        $this->makeRequest([
            'email' => 'test'
        ])->assertSchema('UpdateCurrentUser', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_email_already_exists_when_updating_the_current_user()
    {
        $this->login();

        factory(User::class)->create([
            'email' => 'test@test.com',
        ]);

        $this->makeRequest([
            'email' => 'test@test.com'
        ])->assertSchema('UpdateCurrentUser', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_password_is_too_short_when_updating_the_current_user()
    {
        $this->login();

        $this->makeRequest([
            'password' => 'a',
        ])->assertSchema('UpdateCurrentUser', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_password_doesnt_match_the_regex_when_updating_the_current_user()
    {
        $this->login();

        $this->makeRequest([
            'password' => 'abcdef',
            'password_confirmation' => 'abcdef',
        ])->assertSchema('UpdateCurrentUser', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_password_is_not_confirmed_when_updating_the_current_user()
    {
        $this->login();

        $this->makeRequest([
            'password' => 'Abcdef1!',
        ])->assertSchema('UpdateCurrentUser', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_can_successfully_update_the_users_name()
    {
        $this->login();

        $response = $this->makeRequest(['name' => 'Test Name']);

        $response->assertSchema('UpdateCurrentUser', Response::HTTP_OK);

        $this->assertEquals($response->json('data.name'), 'Test Name');
    }

    /** @test */
    public function it_can_successfully_update_the_users_email_address()
    {
        $this->login();

        $newEmail = faker()->safeEmail;

        $response = $this->makeRequest(['email' => $newEmail]);

        $response->assertSchema('UpdateCurrentUser', Response::HTTP_OK);

        $this->assertEquals($response->json('data.email'), $newEmail);
    }

    /** @test */
    public function it_can_successfully_update_the_users_password()
    {
        $this->login();

        $this->makeRequest([
            'password' => 'Abcdef1!',
            'password_confirmation' => 'Abcdef1!',
        ])->assertSchema('UpdateCurrentUser', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(array $data = []): TestResponse
    {
        return $this->patch(route('update-current-user'), $data);
    }
}
