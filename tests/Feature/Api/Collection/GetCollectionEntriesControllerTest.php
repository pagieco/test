<?php

namespace Tests\Feature\Api\Collection;

use Tests\TestCase;
use App\Http\Response;
use App\Models\Collection;
use App\Models\CollectionEntry;
use App\Models\CollectionField;
use Tests\Feature\AuthenticatedRoute;
use App\Models\Enums\CollectionFieldType;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetCollectionEntriesControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_collection_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetCollectionEntries', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_collection()
    {
        $this->login();

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($collection->external_id)->assertSchema('GetCollectionEntries', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_when_the_collection_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $collection = factory(Collection::class)->create();

        $this->makeRequest($collection->external_id)->assertSchema('GetCollectionEntries', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_returns_an_empty_response_when_no_entries_where_found()
    {
        $this->login()->forceAccess($this->role, 'collection:list-entries');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($collection->external_id)->assertSchema('GetCollectionEntries', Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function it_successfully_executes_the_get_collection_entries_route()
    {
        $this->login()->forceAccess($this->role, 'collection:list-entries');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        factory(CollectionField::class)->create([
            'collection_id' => $collection->local_id,
            'project_id' => $this->project->id,
            'slug' => 'name',
            'type' => CollectionFieldType::PlainText,
            'display_name' => 'Name',
        ]);

        factory(CollectionEntry::class)->create([
            'collection_id' => $collection->local_id,
            'project_id' => $this->project->id,
            'entry_data' => [
                'name' => 'Test name',
            ],
        ]);

        factory(CollectionEntry::class)->create([
            'collection_id' => $collection->local_id,
            'project_id' => $this->project->id,
            'entry_data' => [
                'name' => 'Test other',
            ],
        ]);

        $response = $this->makeRequest($collection->external_id, [
            'filter[name]' => 'Test%',
        ]);

        $response->assertSchema('GetCollectionEntries', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null, array $data = []): TestResponse
    {
        return $this->get(route('get-collection-entries', $data + [
                'collection' => $id ?? faker()->numberBetween(1),
            ]));
    }
}
