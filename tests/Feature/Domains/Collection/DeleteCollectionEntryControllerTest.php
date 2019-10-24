<?php

namespace Tests\Feature\Domains\Collection;

use Tests\TestCase;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use App\Domains\Collection\Models\Collection;
use Illuminate\Foundation\Testing\TestResponse;
use App\Domains\Collection\Models\CollectionEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCollectionEntryControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_entry_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('DeleteCollectionEntry', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_entry()
    {
        $this->login();

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $entry = factory(CollectionEntry::class)->create([
            'collection_id' => $collection->local_id,
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($entry->external_id)->assertSchema('DeleteCollectionEntry', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_exception_when_the_entry_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $collection = factory(Collection::class)->create();

        $entry = factory(CollectionEntry::class)->create([
            'collection_id' => $collection->local_id,
        ]);

        $this->makeRequest($entry->external_id)->assertSchema('DeleteCollectionEntry', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_successfully_executes_the_delete_collection_entry_route()
    {
        $this->login()->forceAccess($this->role, 'collection:delete-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $entry = factory(CollectionEntry::class)->create([
            'collection_id' => $collection->local_id,
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($entry->external_id)->assertSchema('DeleteCollectionEntry', Response::HTTP_NO_CONTENT);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null): TestResponse
    {
        return $this->delete(route('delete-collection-entry', $id ?? faker()->numberBetween(1)));
    }
}
