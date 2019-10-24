<?php

namespace Tests\Feature\Domains\Email;

use Tests\TestCase;
use App\Http\Response;
use App\Domains\Email\Models\Email;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetEmailsControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_returns_an_empty_response_when_no_emails_where_found()
    {
        $this->login()->forceAccess($this->role, 'email:list');

        $this->makeRequest()->assertSchema('GetEmails', Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function it_doesnt_include_emails_from_other_projects()
    {
        $this->login()->forceAccess($this->role, 'email:list');

        factory(Email::class)->create([
            'project_id' => $this->project->id,
        ]);

        factory(Email::class)->create();

        $this->assertCount(1, $this->makeRequest()->json('data'));
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_emails()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetEmails', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_successfully_executes_the_get_emails_route()
    {
        $this->login()->forceAccess($this->role, 'email:list');

        factory(Email::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest()->assertSchema('GetEmails', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(): TestResponse
    {
        return $this->get(route('get-emails'));
    }
}
