<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Response;
use App\Models\Domain;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FrontendControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_throws_a_404_exception_when_the_domain_could_not_be_found()
    {
        $this->get('/')->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_404_exception_when_no_resource_could_be_routed()
    {
        $domainName = parse_url(config('app.domain'), PHP_URL_HOST);

        factory(Domain::class)->create([
            'domain_name' => $domainName,
        ]);

        $response = $this->get('/test-page');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_can_successfully_execute_the_frontend_controller()
    {
        $domainName = parse_url(config('app.domain'), PHP_URL_HOST);

        factory(Domain::class)->create([
            'domain_name' => $domainName,
        ]);

        $this->get('/')->assertStatus(Response::HTTP_OK);
    }
}
