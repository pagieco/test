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

class UpdateCollectionEntryControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_collection_entry_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('UpdateCollectionEntry', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_update_the_entry()
    {
        $this->login();

        $entry = factory(CollectionEntry::class)->create([
            'project_id' => $this->project->id,
            'collection_id' => factory(Collection::class)->create([
                'project_id' => $this->project->id,
            ])->local_id,
        ]);

        $this->makeRequest($entry->external_id)->assertSchema('UpdateCollectionEntry', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_entry_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $entry = factory(CollectionEntry::class)->create();

        $this->makeRequest($entry->external_id)->assertSchema('UpdateCollectionEntry', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_entry_has_validation_errors()
    {
        $this->login()->forceAccess($this->role, 'collection:update-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        factory(CollectionField::class)->create([
            'project_id' => $this->project->id,
            'collection_id' => $collection->local_id,
            'display_name' => 'Name',
            'slug' => 'name',
            'type' => CollectionFieldType::PlainText,
            'validations' => [
                'required',
            ]
        ]);

        $entry = factory(CollectionEntry::class)->create([
            'project_id' => $this->project->id,
            'collection_id' => $collection->local_id,
            'entry_data' => ['name' => ''],
        ]);

        $response = $this->makeRequest($entry->external_id);

        $response->assertSchema('UpdateCollectionEntry', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_empty_when_updating_an_entry()
    {
        $this->login()->forceAccess($this->role, 'collection:update-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $entry = factory(CollectionEntry::class)->create([
            'project_id' => $this->project->id,
            'collection_id' => $collection->local_id,
            'entry_data' => ['name' => ''],
        ]);

        $response = $this->makeRequest($entry->external_id, [
            'name' => '',
        ]);

        $response->assertSchema('UpdateCollectionEntry', Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_short_when_updating_an_entry()
    {
        $this->login()->forceAccess($this->role, 'collection:update-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $entry = factory(CollectionEntry::class)->create([
            'project_id' => $this->project->id,
            'collection_id' => $collection->local_id,
            'entry_data' => ['name' => ''],
        ]);

        $response = $this->makeRequest($entry->external_id, [
            'name' => 'a',
        ]);

        $response->assertSchema('UpdateCollectionEntry', Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_long_when_updating_an_entry()
    {
        $this->login()->forceAccess($this->role, 'collection:update-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $entry = factory(CollectionEntry::class)->create([
            'project_id' => $this->project->id,
            'collection_id' => $collection->local_id,
            'entry_data' => ['name' => ''],
        ]);

        $response = $this->makeRequest($entry->external_id, [
            'name' => str_repeat('a', 101),
        ]);

        $response->assertSchema('UpdateCollectionEntry', Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_is_empty_when_updating_an_entry()
    {
        $this->login()->forceAccess($this->role, 'collection:update-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $entry = factory(CollectionEntry::class)->create([
            'project_id' => $this->project->id,
            'collection_id' => $collection->local_id,
            'entry_data' => ['name' => ''],
        ]);

        $response = $this->makeRequest($entry->external_id, [
            'slug' => '',
        ]);

        $response->assertSchema('UpdateCollectionEntry', Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors('slug');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_is_too_long_when_updating_an_entry()
    {
        $this->login()->forceAccess($this->role, 'collection:update-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $entry = factory(CollectionEntry::class)->create([
            'project_id' => $this->project->id,
            'collection_id' => $collection->local_id,
            'entry_data' => ['name' => ''],
        ]);

        $response = $this->makeRequest($entry->external_id, [
            'slug' => str_repeat('a', 251),
        ]);

        $response->assertSchema('UpdateCollectionEntry', Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors('slug');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_already_exists_in_the_same_collection_when_updating_an_entry()
    {
        $this->login()->forceAccess($this->role, 'collection:update-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        factory(CollectionEntry::class)->create([
            'slug' => 'entry-slug',
            'project_id' => $this->project->id,
            'collection_id' => $collection->local_id,
            'entry_data' => ['name' => ''],
        ]);

        $entry = factory(CollectionEntry::class)->create([
            'slug' => 'test-slug',
            'project_id' => $this->project->id,
            'collection_id' => $collection->local_id,
            'entry_data' => ['name' => ''],
        ]);

        $response = $this->makeRequest($entry->external_id, [
            'slug' => 'entry-slug',
        ]);

        $response->assertSchema('UpdateCollectionEntry', Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors('slug');
    }

    /** @test */
    public function it_successfully_executes_the_update_collection_entry_route()
    {
        $this->login()->forceAccess($this->role, 'collection:update-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $entry = factory(CollectionEntry::class)->create([
            'slug' => 'test-slug',
            'project_id' => $this->project->id,
            'collection_id' => $collection->local_id,
            'entry_data' => ['name' => '', 'age' => 123],
        ]);

        $response = $this->makeRequest($entry->external_id, [
            'slug' => 'entry-slug',
            'entry_data' => [
                'name' => 'new name',
            ],
        ]);

        $response->assertSchema('UpdateCollectionEntry', Response::HTTP_OK);

        $response->assertJson([
            'data' => [
                'slug' => 'entry-slug',
                'entry_data' => [
                    'name' => 'new name',
                    'age' => 123,
                ],
            ],
        ]);
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
        return $this->patch(route('update-collection-entry', $id ?? faker()->numberBetween(1)), $data);
    }
}
