<?php

namespace Tests\Feature\Domains\Page;

use Tests\TestCase;
use App\Http\Response;
use App\Domains\Page\Models\Page;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublishPageControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_page_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('PublishPage', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_page()
    {
        $this->login();

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($page->external_id, [
            'dom' => [null],
            'css' => [null],
        ]);

        $response->assertSchema('PublishPage', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_page_exists_but_is_not_part_of_the_project()
    {
        $this->login()->forceAccess($this->role, 'page:publish');

        $page = factory(Page::class)->create();

        $response = $this->makeRequest($page->external_id, [
            'dom' => [null],
            'css' => [null],
        ]);

        $response->assertSchema('PublishPage', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_successfully_executes_the_publish_page_route()
    {
        $this->login()->forceAccess($this->role, 'page:publish');

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($page->external_id, [
            'dom' => [
                'uuid' => faker()->uuid,
                'nodeType' => '--empty-root-node--',
                'children' => [
                    [
                        'uuid' => 1,
                        'nodeType' => 'body',
                        'nodeAttributes' => [
                            'test' => 'value',
                        ],
                        'children' => [
                            [
                                'uuid' => 2,
                                'nodeType' => 'div',
                                'textContent' => 'lipsum',
                            ],
                        ],
                    ],
                ],
            ],
            'css' => [null],
        ]);

        $response->assertSchema('PublishPage', Response::HTTP_OK);
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
        return $this->post(route('publish-page', $id ?? faker()->numberBetween(1)), $data);
    }
}
