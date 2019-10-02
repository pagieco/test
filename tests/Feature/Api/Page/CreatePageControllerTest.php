<?php

namespace Tests\Feature\Api\Page;

use Tests\TestCase;
use App\Models\Page;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePageControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_permission_to_create_a_new_page()
    {
        $this->login();

        $domain = $this->project->domains->first();

        $this->makeRequest([
            'domain_id' => $domain->id,
            'name' => 'Test page',
            'slug' => '/test-slug',
        ])->assertSchema('CreatePage', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_missing_when_creating_a_new_page()
    {
        $this->login();

        $this->makeRequest([
            'slug' => '/test-slug',
        ])->assertSchema('CreatePage', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_short_when_creating_a_new_page()
    {
        $this->login();

        $this->makeRequest([
            'name' => 'a',
            'slug' => '/test-slug',
        ])->assertSchema('CreatePage', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_already_used_in_the_project_when_creating_a_new_page()
    {
        $this->login();

        factory(Page::class)->create([
            'project_id' => $this->project->id,
            'name' => 'Test Page',
        ]);

        $this->makeRequest([
            'name' => 'Test Page',
            'slug' => '/',
        ])->assertSchema('CreatePage', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_long_when_creating_a_new_page()
    {
        $this->login();

        $this->makeRequest([
            'name' => str_repeat('a', 251),
            'slug' => '/test-slug',
        ])->assertSchema('CreatePage', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_is_missing_when_creating_a_new_page()
    {
        $this->login();

        $this->makeRequest([
            'name' => 'Test Page',
            'slug' => '',
        ])->assertSchema('CreatePage', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_already_exists_in_the_project_when_creating_a_new_page()
    {
        $this->login();

        factory(Page::class)->create([
            'project_id' => $this->project->id,
            'slug' => '/test-slug',
        ]);

        $this->makeRequest([
            'name' => 'Test Page',
            'slug' => '/test-slug',
        ])->assertSchema('CreatePage', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_is_too_long_when_creating_a_new_page()
    {
        $this->login();

        $this->makeRequest([
            'name' => 'Test Page',
            'slug' => str_repeat('a', 251),
        ])->assertSchema('CreatePage', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_successfully_creates_a_new_page()
    {
        $this->login()->forceAccess($this->role, 'page:create');

        $domain = $this->project->domains->first();

        $this->makeRequest([
            'domain_id' => $domain->id,
            'name' => 'Test Page',
            'slug' => '/test-slug',
        ])->assertSchema('CreatePage', Response::HTTP_CREATED);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(array $data = []): TestResponse
    {
        return $this->post(route('create-page', $data));
    }
}
