<?php

namespace Tests\Feature\Api\Collection;

use Tests\TestCase;
use App\Http\Response;
use App\Models\Collection;
use App\Models\CollectionEntry;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCollectionEntryControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_collection_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('CreateCollectionEntry', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_403_forbidden_exception_when_the_user_has_no_permission_to_create_a_new_entry()
    {
        $this->login();

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($collection->external_id, [
            'name' => faker()->name,
            'slug' => '/',
            'entry_data' => [
                'name' => 'value',
            ],
        ])->assertSchema('CreateCollectionEntry', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_collection_exists_but_is_not_part_of_the_project()
    {
        $this->login();

        $collection = factory(Collection::class)->create();

        $this->makeRequest($collection->external_id)->assertSchema('CreateCollectionEntry', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_422_exeption_when_the_entry_has_validation_errors()
    {
        $this->login()->forceAccess($this->role, 'collection:create-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($collection->external_id)->assertSchema('CreateCollectionEntry', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_missing_when_creating_a_new_entry()
    {
        $this->login()->forceAccess($this->role, 'collection:create-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($collection->external_id, [
            'name' => null,
            'slug' => 'test-slug',
            'entry_data' => [
                'test' => 'value',
            ],
        ])->assertSchema('CreateCollectionEntry', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_short_when_creating_a_new_entry()
    {
        $this->login()->forceAccess($this->role, 'collection:create-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($collection->external_id, [
            'name' => 'a',
            'slug' => 'test-slug',
            'entry_data' => [
                'test' => 'value',
            ],
        ])->assertSchema('CreateCollectionEntry', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_long_when_creating_a_new_entry()
    {
        $this->login()->forceAccess($this->role, 'collection:create-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($collection->external_id, [
            'name' => str_repeat('a', 101),
            'slug' => 'test-slug',
            'entry_data' => [
                'test' => 'value',
            ],
        ])->assertSchema('CreateCollectionEntry', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_is_missing_when_creating_a_new_entry()
    {
        $this->login()->forceAccess($this->role, 'collection:create-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($collection->external_id, [
            'name' => faker()->name,
            'slug' => null,
            'entry_data' => [
                'test' => 'value',
            ],
        ])->assertSchema('CreateCollectionEntry', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_is_too_long_when_creating_a_new_entry()
    {
        $this->login()->forceAccess($this->role, 'collection:create-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($collection->external_id, [
            'name' => faker()->name,
            'slug' => str_repeat('a', 251),
            'entry_data' => [
                'test' => 'value',
            ],
        ])->assertSchema('CreateCollectionEntry', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_already_exists_in_the_same_collection_when_creating_a_new_entry()
    {
        $this->login()->forceAccess($this->role, 'collection:create-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        factory(CollectionEntry::class)->create([
            'collection_id' => $collection->local_id,
            'slug' => 'test-slug',
        ]);

        $this->makeRequest($collection->external_id, [
            'name' => faker()->name,
            'slug' => 'test-slug',
            'entry_data' => [
                'test' => 'value',
            ],
        ])->assertSchema('CreateCollectionEntry', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_successfully_executes_the_create_collection_entry_route()
    {
        $this->login()->forceAccess($this->role, 'collection:create-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($collection->external_id, [
            'name' => faker()->name,
            'slug' => faker()->slug,
            'entry_data' => [
                'name' => 'value',
            ],
        ])->assertSchema('CreateCollectionEntry', Response::HTTP_CREATED);
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
        return $this->post(route('create-collection-entry', $id ?? faker()->numberBetween(1)), $data);
    }
}
