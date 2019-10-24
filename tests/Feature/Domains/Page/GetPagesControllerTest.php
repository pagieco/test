<?php

namespace Tests\Feature\Domains\Page;

use Tests\TestCase;
use App\Http\Response;
use App\Domains\Page\Models\Page;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetPagesControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_doesnt_include_pages_from_other_projects()
    {
        $this->login()->forceAccess($this->role, 'page:list');

        factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        factory(Page::class)->create();

        $this->assertCount(2, $this->makeRequest()->json('data'));
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_pages()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetPages', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_successfully_executes_the_get_pages_route()
    {
        $this->login()->forceAccess($this->role, 'page:list');

        factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest()->assertSchema('GetPages', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(): TestResponse
    {
        return $this->get(route('get-pages'));
    }
}
