<?php

namespace Tests\Feature\Api\Domain;

use Tests\TestCase;
use App\Http\Response;
use App\Models\Domain;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateDomainControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_permission_to_create_a_new_domain()
    {
        $this->login();

        $response = $this->makeRequest([
            'domain_name' => faker()->domainName,
            'timezone' => faker()->timezone,
        ]);

        $response->assertSchema('CreateDomain', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_domain_name_is_missing_when_creating_a_new_domain()
    {
        $this->login();

        $response = $this->makeRequest([
            'timezone' => faker()->timezone,
        ]);

        $response->assertSchema('CreateDomain', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.domain_name.0'), 'The domain name field is required.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_domain_name_already_exists_when_creating_a_new_domain()
    {
        $this->login()->forceAccess($this->role, 'domain:create');

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest([
            'domain_name' => $domain->domain_name,
            'timezone' => faker()->timezone,
        ]);

        $response->assertSchema('CreateDomain', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.domain_name.0'), 'The domain name has already been taken.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_gtm_is_empty_when_creating_a_new_domain()
    {
        $this->login()->forceAccess($this->role, 'domain:create');

        $response = $this->makeRequest([
            'domain_name' => faker()->domainName,
            'timezone' => faker()->timezone,
            'gtm' => '',
        ]);

        $response->assertSchema('CreateDomain', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.gtm.0'), 'The gtm field must have a value.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_google_site_verification_id_is_empty_when_creating_a_new_domain()
    {
        $this->login()->forceAccess($this->role, 'domain:create');

        $response = $this->makeRequest([
            'domain_name' => faker()->domainName,
            'timezone' => faker()->timezone,
            'google_site_verification_id' => '',
        ]);

        $response->assertSchema('CreateDomain', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.google_site_verification_id.0'), 'The google site verification id field must have a value.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_facebook_pixel_id_is_empty_when_creating_a_new_domain()
    {
        $this->login()->forceAccess($this->role, 'domain:create');

        $response = $this->makeRequest([
            'domain_name' => faker()->domainName,
            'timezone' => faker()->timezone,
            'facebook_pixel_id' => '',
        ]);

        $response->assertSchema('CreateDomain', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.facebook_pixel_id.0'), 'The facebook pixel id field must have a value.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_timezone_is_missing_when_creating_a_new_domain()
    {
        $this->login()->forceAccess($this->role, 'domain:create');

        $response = $this->makeRequest([
            'domain_name' => faker()->domainName,
        ]);

        $response->assertSchema('CreateDomain', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.timezone.0'), 'The timezone field is required.');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_timezone_is_invalid_when_creating_a_new_domain()
    {
        $this->login()->forceAccess($this->role, 'domain:create');

        $response = $this->makeRequest([
            'domain_name' => faker()->domainName,
            'timezone' => 'invalid/timezone',
        ]);

        $response->assertSchema('CreateDomain', Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($response->json('errors.timezone.0'), 'The timezone must be a valid zone.');
    }

    /** @test */
    public function it_successfully_executes_the_create_domain_route()
    {
        $this->login()->forceAccess($this->role, 'domain:create');

        $response = $this->makeRequest([
            'domain_name' => faker()->domainName,
            'timezone' => faker()->timezone,
        ]);

        $response->assertSchema('CreateDomain', Response::HTTP_CREATED);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(array $data = []): TestResponse
    {
        return $this->post(route('create-domain', $data));
    }
}
