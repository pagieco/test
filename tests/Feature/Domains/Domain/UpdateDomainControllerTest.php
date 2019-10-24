<?php

namespace Tests\Feature\Domains\Domain;

use Tests\TestCase;
use App\Http\Response;
use App\Domains\Domain\Models\Domain;
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

        $response = $this->makeRequest($domain->id, [
            'domain_name' => faker()->domainName,
            'timezone' => faker()->timezone,
        ]);

        $response->assertSchema('UpdateDomain', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_domain_exists_but_is_not_part_of_the_project()
    {
        $this->login()->forceAccess($this->role, 'domain:update');

        $domain = factory(Domain::class)->create();

        $response = $this->makeRequest($domain->id);

        $response->assertSchema('UpdateDomain', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_domain_name_is_not_posted_when_updating_a_domain()
    {
        $this->login()->forceAccess($this->role, 'domain:update');

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($domain->id);

        $response->assertSchema('UpdateDomain', Response::HTTP_UNPROCESSABLE_ENTITY);
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

        $response = $this->makeRequest($domain->id, [
            'domain_name' => 'test-domain.com',
        ]);

        $response->assertSchema('UpdateDomain', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_gtm_is_posted_but_is_empty_when_updating_a_domain()
    {
        $this->login()->forceAccess($this->role, 'domain:update');

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($domain->id, [
            'domain_name' => 'test-domain.com',
            'gtm' => '',
        ]);

        $response->assertSchema('UpdateDomain', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_google_site_verification_id_is_posted_but_is_empty_when_updating_a_domain()
    {
        $this->login()->forceAccess($this->role, 'domain:update');

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($domain->id, [
            'domain_name' => 'test-domain.com',
            'google_site_verification_id' => '',
        ]);

        $response->assertSchema('UpdateDomain', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_facebook_pixel_id_is_posted_but_is_empty_when_updating_a_domain()
    {
        $this->login()->forceAccess($this->role, 'domain:update');

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($domain->id, [
            'domain_name' => 'test-domain.com',
            'facebook_pixel_id' => '',
        ]);

        $response->assertSchema('UpdateDomain', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_timezone_is_invalid_when_updating_a_domain()
    {
        $this->login()->forceAccess($this->role, 'domain:update');

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($domain->id, [
            'domain_name' => 'test-domain.com',
            'timezone' => 'fake/timezone',
        ]);

        $response->assertSchema('UpdateDomain', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_successfully_executes_the_update_domain_route()
    {
        $this->login()->forceAccess($this->role, 'domain:update');

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($domain->id, [
            'domain_name' => 'test-domain.com',
        ]);

        $response->assertSchema('UpdateDomain', Response::HTTP_OK);
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
