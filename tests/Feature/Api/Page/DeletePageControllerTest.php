<?php

namespace Tests\Feature\Api\Page;

use Tests\TestCase;
use App\Models\Page;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletePageControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_page_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('DeletePage', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_page()
    {
        $this->login();

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($page->id)->assertSchema('DeletePage', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_page_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $page = factory(Page::class)->create();

        $this->makeRequest($page->id)->assertSchema('DeletePage', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_can_successfully_execute_the_delete_page_route()
    {
        $this->login()->forceAccess($this->role, 'page:delete');

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($page->id)->assertSchema('DeletePage', Response::HTTP_NO_CONTENT);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->delete(route('delete-page', $id ?? faker()->randomNumber()));
    }
}
