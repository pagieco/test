<?php

namespace Tests\Feature\Api\Collections;

use Tests\TestCase;
use App\Http\Response;
use App\Models\Domain;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetDomainsControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_doesnt_include_domains_from_other_projects()
    {
        $this->login()->forceAccess($this->role, 'domain:list');

        factory(Domain::class)->create();

        $this->assertCount(1, $this->makeRequest()->json('data'));
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_domains()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetDomains', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_successfully_executes_the_get_domains_route()
    {
        $this->login()->forceAccess($this->role, 'domain:list');

        $this->makeRequest()->assertSchema('GetDomains', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(): TestResponse
    {
        return $this->get(route('get-domains'));
    }
}
