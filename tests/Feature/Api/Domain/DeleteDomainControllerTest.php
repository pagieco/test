<?php

namespace Tests\Feature\Api\Domain;

use Tests\TestCase;
use App\Http\Response;
use App\Models\Domain;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteDomainControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_domain_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('DeleteDomain', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_delete_the_domain()
    {
        $this->login();

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($domain->id)->assertSchema('DeleteDomain', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_domain_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $domain = factory(Domain::class)->create();

        $this->makeRequest($domain->id)->assertSchema('DeleteDomain', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_400_bad_request_exception_when_the_user_tries_to_delete_the_last_domain_of_the_project()
    {
        $this->login()->forceAccess($this->role, 'domain:delete');

        $this->makeRequest($this->project->domains->first()->id)->assertSchema('DeleteDomain', Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    public function it_can_successfully_execute_the_delete_domain_route()
    {
        $this->login()->forceAccess($this->role, 'domain:delete');

        factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($domain->id)->assertSchema('DeleteDomain', Response::HTTP_NO_CONTENT);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->delete(route('delete-domain', $id ?? faker()->numberBetween(1)));
    }
}
