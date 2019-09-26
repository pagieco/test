<?php

namespace Tests\Feature\Api\Page;

use Tests\TestCase;
use App\Models\Page;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePageControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_page_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('UpdatePage', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_page()
    {
        $this->login();

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($page->id)->assertSchema('UpdatePage', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_page_exists_but_is_not_part_of_the_project()
    {
        $this->login()->forceAccess($this->role, 'page:update');

        $page = factory(Page::class)->create();

        $this->makeRequest($page->id)->assertSchema('UpdatePage', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_exists_but_is_empty_when_updating_a_page()
    {
        $this->login()->forceAccess($this->role, 'page:update');

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($page->id, [
            'name' => '',
        ])->assertSchema('UpdatePage', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_short_when_updating_a_page()
    {
        $this->login()->forceAccess($this->role, 'page:update');

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($page->id, [
            'name' => 'a',
        ])->assertSchema('UpdatePage', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_long_when_updating_a_page()
    {
        $this->login()->forceAccess($this->role, 'page:update');

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($page->id, [
            'name' => str_repeat('a', 251),
        ])->assertSchema('UpdatePage', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_already_exists_when_updating_a_page()
    {
        $this->login()->forceAccess($this->role, 'page:update');

        factory(Page::class)->create([
            'project_id' => $this->project->id,
            'name' => 'Test Name',
        ]);

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
            'name' => 'Old Name',
        ]);

        $this->makeRequest($page->id, [
            'name' => 'Test Name',
        ])->assertSchema('UpdatePage', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_exists_but_is_empty_when_updating_a_page()
    {
        $this->login()->forceAccess($this->role, 'page:update');

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($page->id, [
            'slug' => '',
        ])->assertSchema('UpdatePage', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_is_too_long_when_updating_a_page()
    {
        $this->login()->forceAccess($this->role, 'page:update');

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($page->id, [
            'slug' => str_repeat('a', 251),
        ])->assertSchema('UpdatePage', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_already_exists_when_updating_a_page()
    {
        $this->login()->forceAccess($this->role, 'page:update');

        factory(Page::class)->create([
            'project_id' => $this->project->id,
            'slug' => '/test-slug',
        ]);

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
            'name' => '/old-slug',
        ]);

        $this->makeRequest($page->id, [
            'slug' => '/test-slug',
        ])->assertSchema('UpdatePage', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_successfully_executes_the_update_page_route()
    {
        $this->login()->forceAccess($this->role, 'page:update');

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($page->id, [
            'name' => 'Test Name',
            'slug' => 'test-slug',
        ])->assertSchema('UpdatePage', Response::HTTP_OK);
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
        return $this->patch(route('update-page', $id ?? faker()->numberBetween(1)), $data);
    }
}
