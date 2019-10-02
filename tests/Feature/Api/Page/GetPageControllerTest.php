<?php

namespace Tests\Feature\Api\Page;

use Tests\TestCase;
use App\Models\Page;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetPageControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_page_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetPage', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_page()
    {
        $this->login();

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($page->external_id)->assertSchema('GetPage', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_page_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $page = factory(Page::class)->create();

        $this->makeRequest($page->external_id)->assertSchema('GetPage', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_successfully_executes_the_get_page_route()
    {
        $this->login()->forceAccess($this->role, 'page:view');

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($page->external_id)->assertSchema('GetPage', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->get(route('get-page', $id ?? faker()->numberBetween(1)));
    }
}
