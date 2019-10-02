<?php

namespace Tests\Feature\Api\Profile;

use Tests\TestCase;
use App\Http\Response;
use App\Models\Profile;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateProfileControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_profile_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('UpdateProfile', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_trouws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_profile()
    {
        $this->login();

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($profile->external_id)->assertSchema('UpdateProfile', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_profile_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $profile = factory(Profile::class)->create();

        $this->makeRequest($profile->external_id)->assertSchema('UpdateProfile', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_email_exists_but_is_empty_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'email' => null,
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.email.0'), 'The email field must have a value.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_email_is_invalid_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'email' => 'test value',
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.email.0'), 'The email must be a valid email address.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_first_name_exists_but_is_empty_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'first_name' => null,
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.first_name.0'), 'The first name field must have a value.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_first_name_is_too_short_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'first_name' => 'a',
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.first_name.0'), 'The first name must be at least 3 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_first_name_is_too_long_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'first_name' => str_repeat('a', 101),
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.first_name.0'), 'The first name may not be greater than 100 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_last_name_exists_but_is_empty_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'last_name' => null,
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.last_name.0'), 'The last name field must have a value.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_last_name_is_too_short_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'last_name' => 'a',
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.last_name.0'), 'The last name must be at least 3 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_last_name_is_too_long_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'last_name' => str_repeat('a', 101),
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.last_name.0'), 'The last name may not be greater than 100 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_address_1_field_exists_but_is_empty_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'address_1' => null,
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.address_1.0'), 'The address 1 field must have a value.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_address_1_field_is_too_short_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'address_1' => 'a',
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.address_1.0'), 'The address 1 must be at least 3 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_address_1_field_is_too_long_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'address_1' => str_repeat('a', 101),
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.address_1.0'), 'The address 1 may not be greater than 100 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_address_2_field_exists_but_is_empty_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'address_2' => null,
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.address_2.0'), 'The address 2 field must have a value.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_address_2_field_is_too_short_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'address_2' => 'a',
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.address_2.0'), 'The address 2 must be at least 3 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_address_2_field_is_too_long_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'address_2' => str_repeat('a', 101),
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.address_2.0'), 'The address 2 may not be greater than 100 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_city_field_exists_but_is_empty_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'city' => null,
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.city.0'), 'The city field must have a value.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_city_field_is_too_short_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'city' => 'a',
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.city.0'), 'The city must be at least 3 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_city_field_is_too_long_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'city' => str_repeat('a', 101),
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.city.0'), 'The city may not be greater than 100 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_state_field_exists_but_is_empty_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'state' => null,
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.state.0'), 'The state field must have a value.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_state_field_is_too_short_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'state' => 'a',
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.state.0'), 'The state must be at least 3 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_state_field_is_too_long_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'state' => str_repeat('a', 101),
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.state.0'), 'The state may not be greater than 100 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_zip_field_exists_but_is_empty_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'zip' => null,
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.zip.0'), 'The zip field must have a value.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_zip_field_is_too_short_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'zip' => 'a',
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.zip.0'), 'The zip must be at least 3 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_zip_field_is_too_long_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'zip' => str_repeat('a', 101),
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.zip.0'), 'The zip may not be greater than 100 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_country_field_exists_but_is_empty_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'country' => null,
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.country.0'), 'The country field must have a value.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_country_field_is_too_short_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'country' => 'a',
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.country.0'), 'The country must be at least 3 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_country_field_is_too_long_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'country' => str_repeat('a', 101),
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.country.0'), 'The country may not be greater than 100 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_phone_field_exists_but_is_empty_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'phone' => null,
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.phone.0'), 'The phone field must have a value.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_phone_field_is_too_short_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'phone' => 'a',
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.phone.0'), 'The phone must be at least 3 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_phone_field_is_too_long_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'phone' => str_repeat('a', 101),
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.phone.0'), 'The phone may not be greater than 100 characters.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_timezone_field_exists_but_is_empty_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'timezone' => null,
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.timezone.0'), 'The timezone field must have a value.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_timezone_field_is_invalid_when_updating_the_profile()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'timezone' => 'invalid/timezone',
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.timezone.0'), 'The timezone must be a valid zone.');
    }

    /** @test */
    public function it_successfully_executes_the_update_profile_route()
    {
        $this->login()->forceAccess($this->role, 'profile:update');

        $profile = factory(Profile::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($profile->external_id, [
            'email' => $updatedEmail = faker()->safeEmail,
        ]);

        $response->assertSchema('UpdateProfile', Response::HTTP_OK);

        $this->assertEquals($updatedEmail, $response->json('data.email'));
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
        return $this->patch(route('update-profile', $id ?? faker()->numberBetween(1)), $data);
    }
}
