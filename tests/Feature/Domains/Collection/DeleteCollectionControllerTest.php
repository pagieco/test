<?php

namespace Tests\Feature\Domains\Collection;

use Tests\TestCase;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use App\Domains\Collection\Models\Collection;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCollectionControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_collection_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('DeleteCollection', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_collection()
    {
        $this->login();

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($collection->external_id)->assertSchema('DeleteCollection', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_collection_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $collection = factory(Collection::class)->create();

        $this->makeRequest($collection->external_id)->assertSchema('DeleteCollection', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_can_successfully_execute_the_delete_collection_route()
    {
        $this->login()->forceAccess($this->role, 'collection:delete');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($collection->external_id)->assertSchema('DeleteCollection', Response::HTTP_NO_CONTENT);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->delete(route('delete-collection', $id ?? faker()->numberBetween(1)));
    }
}
