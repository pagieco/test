<?php

namespace Tests\Feature\Api\Email;

use Tests\TestCase;
use App\Models\Email;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteEmailControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_email_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('DeleteEmail', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_email()
    {
        $this->login();

        $email = factory(Email::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($email->id)->assertSchema('DeleteEmail', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_email_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $email = factory(Email::class)->create();

        $this->makeRequest($email->id)->assertSchema('DeleteEmail', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_can_successfully_execute_the_delete_email_route()
    {
        $this->login()->forceAccess($this->role, 'email:delete');

        $email = factory(Email::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($email->id)->assertSchema('DeleteEmail', Response::HTTP_NO_CONTENT);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->delete(route('delete-email', $id ?? faker()->randomNumber()));
    }
}
