<?php

namespace Tests\Feature\Domains\Email;

use Tests\TestCase;
use App\Http\Response;
use App\Domains\Email\Models\Email;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateEmailControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_email_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('UpdateEmail', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_email()
    {
        $this->login();

        $email = factory(Email::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($email->id)->assertSchema('UpdateEmail', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_email_exists_but_is_not_part_of_the_project()
    {
        $this->login()->forceAccess($this->role, 'email:update');

        $email = factory(Email::class)->create();

        $this->makeRequest($email->id)->assertSchema('UpdateEmail', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_exists_but_is_empty_when_updating_a_email()
    {
        $this->login()->forceAccess($this->role, 'email:update');

        $email = factory(Email::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($email->id, [
            'name' => '',
        ])->assertSchema('UpdateEmail', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_short_when_updating_a_email()
    {
        $this->login()->forceAccess($this->role, 'email:update');

        $email = factory(Email::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($email->id, [
            'name' => 'a',
        ])->assertSchema('UpdateEmail', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_long_when_updating_a_email()
    {
        $this->login()->forceAccess($this->role, 'email:update');

        $email = factory(Email::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($email->id, [
            'name' => str_repeat('a', 251),
        ])->assertSchema('UpdateEmail', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_already_exists_when_updating_a_email()
    {
        $this->login()->forceAccess($this->role, 'email:update');

        factory(Email::class)->create([
            'project_id' => $this->project->id,
            'name' => 'Test Name',
        ]);

        $email = factory(Email::class)->create([
            'project_id' => $this->project->id,
            'name' => 'Old Name',
        ]);

        $this->makeRequest($email->id, [
            'name' => 'Test Name',
        ])->assertSchema('UpdateEmail', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_successfully_executes_the_update_email_route()
    {
        $this->login()->forceAccess($this->role, 'email:update');

        $email = factory(Email::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($email->id, [
            'name' => 'Test Name',
        ])->assertSchema('UpdateEmail', Response::HTTP_OK);
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
        return $this->patch(route('update-email', $id ?? faker()->numberBetween(1)), $data);
    }
}
