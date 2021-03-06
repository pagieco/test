<?php

namespace Tests\Feature\Domains\Domain;

use Tests\TestCase;
use App\Http\Response;
use App\Domains\Domain\Models\Domain;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetDomainControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_domain_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetDomain', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_domain()
    {
        $this->login();

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($domain->id)->assertSchema('GetDomain', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_domain_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $domain = factory(Domain::class)->create();

        $this->makeRequest($domain->id)->assertSchema('GetDomain', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_successfully_executes_the_get_domain_route()
    {
        $this->login()->forceAccess($this->role, 'domain:view');

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($domain->id)->assertSchema('GetDomain', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->get(route('get-domain', $id ?? faker()->numberBetween(1)));
    }
}
