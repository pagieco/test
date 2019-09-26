<?php

namespace Tests\Feature\Api\Domain;

use Tests\TestCase;
use App\Http\Response;
use App\Models\Domain;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateDomainControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_domain_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('UpdateDomain', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_domain()
    {
        $this->login();

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($domain->id, [
            'domain_name' => faker()->domainName,
        ])->assertSchema('UpdateDomain', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_domain_exists_but_is_not_part_of_the_project()
    {
        $this->login()->forceAccess($this->role, 'domain:update');

        $domain = factory(Domain::class)->create();

        $this->makeRequest($domain->id)->assertSchema('UpdateDomain', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_domain_name_is_not_posted_when_updating_a_domain()
    {
        $this->login()->forceAccess($this->role, 'domain:update');

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($domain->id)->assertSchema('UpdateDomain', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_domain_name_already_exists_when_updating_a_domain()
    {
        $this->login()->forceAccess($this->role, 'domain:update');

        factory(Domain::class)->create([
            'domain_name' => 'test-domain.com',
        ]);

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($domain->id, [
            'domain_name' => 'test-domain.com',
        ])->assertSchema('UpdateDomain', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_successfully_executes_the_update_domain_route()
    {
        $this->login()->forceAccess($this->role, 'domain:update');

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($domain->id, [
            'domain_name' => 'test-domain.com',
        ])->assertSchema('UpdateDomain', Response::HTTP_OK);
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
        return $this->patch(route('update-domain', $id ?? faker()->numberBetween(1)), $data);
    }
}
