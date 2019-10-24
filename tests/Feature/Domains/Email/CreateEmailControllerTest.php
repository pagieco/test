<?php

namespace Tests\Feature\Domains\Email;

use Tests\TestCase;
use App\Http\Response;
use App\Domains\Email\Models\Email;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateEmailControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_permission_to_create_a_new_email()
    {
        $this->login();

        $this->makeRequest([
            'name' => 'Test Email',
        ])->assertSchema('CreateEmail', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_missing_when_creating_a_new_email()
    {
        $this->login();

        $this->makeRequest()->assertSchema('CreateEmail', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_short_when_creating_a_new_email()
    {
        $this->login();

        $this->makeRequest([
            'name' => 'a',
        ])->assertSchema('CreateEmail', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_long_when_creating_a_new_email()
    {
        $this->login();

        $this->makeRequest([
            'name' => str_repeat('a', 251),
        ])->assertSchema('CreateEmail', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_already_used_in_the_project_when_creating_a_new_email()
    {
        $this->login();

        factory(Email::class)->create([
            'project_id' => $this->project->id,
            'name' => 'Test Email',
        ]);

        $this->makeRequest([
            'name' => 'Test Email',
        ])->assertSchema('CreateEmail', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_successfully_creates_a_new_email()
    {
        $this->login()->forceAccess($this->role, 'email:create');

        $this->makeRequest([
            'name' => 'Test Email',
        ])->assertSchema('CreateEmail', Response::HTTP_CREATED);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(array $data = []): TestResponse
    {
        return $this->post(route('create-email', $data));
    }
}
