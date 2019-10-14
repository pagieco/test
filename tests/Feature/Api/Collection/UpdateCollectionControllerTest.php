<?php

namespace Tests\Feature\Api\Collection;

use Tests\TestCase;
use App\Http\Response;
use App\Models\Collection;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCollectionControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_collection_could_not_be_found()
    {
        $this->login();

        $this->makeRequest()->assertSchema('UpdateCollection', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_collection()
    {
        $this->login();

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->makeRequest($collection->external_id)->assertSchema('UpdateCollection', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_collection_exists_but_is_not_part_of_the_project()
    {
        $this->login()->forceAccess($this->role, 'collection:update');

        $collection = factory(Collection::class)->create();

        $this->makeRequest($collection->external_id)->assertSchema('UpdateCollection', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_short_when_updating_a_collection()
    {
        $this->login()->forceAccess($this->role, 'collection:update');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($collection->external_id, [
            'name' => 'a',
        ]);

        $response->assertSchema('UpdateCollection', Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_long_when_updating_a_collection()
    {
        $this->login()->forceAccess($this->role, 'collection:update');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($collection->external_id, [
            'name' => str_repeat('a', 101),
        ]);

        $response->assertSchema('UpdateCollection', Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_description_is_too_long_when_updating_a_collection()
    {
        $this->login()->forceAccess($this->role, 'collection:update');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($collection->external_id, [
            'description' => str_repeat('a', 251),
        ]);

        $response->assertSchema('UpdateCollection', Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors('description');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_fields_array_is_empty_when_updating_a_collection()
    {
        $this->login()->forceAccess($this->role, 'collection:update');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($collection->external_id, [
            'fields' => [],
        ]);

        $response->assertSchema('UpdateCollection', Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors('fields');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_display_name_key_is_too_short_when_updating_a_collection()
    {
        $this->login()->forceAccess($this->role, 'collection:update');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($collection->external_id, [
            'fields' => [
                'testfield' => [
                    'display_name' => 'a',
                ],
            ],
        ]);

        $response->assertSchema('UpdateCollection', Response::HTTP_UNPROCESSABLE_ENTITY);


        $response->assertJsonValidationErrors('fields.testfield.display_name');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_display_name_key_is_too_long_when_updating_a_collection()
    {
        $this->login()->forceAccess($this->role, 'collection:update');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($collection->external_id, [
            'fields' => [
                'testfield' => [
                    'display_name' => str_repeat('a', 101),
                ],
            ],
        ]);

        $response->assertSchema('UpdateCollection', Response::HTTP_UNPROCESSABLE_ENTITY);


        $response->assertJsonValidationErrors('fields.testfield.display_name');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_is_too_short_when_updating_a_collecton()
    {
        $this->login()->forceAccess($this->role, 'collection:update');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($collection->external_id, [
            'fields' => [
                'testfield' => [
                    'slug' => 'a',
                ],
            ],
        ]);

        $response->assertSchema('UpdateCollection', Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors('fields.testfield.slug');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_is_too_long_when_updating_a_collection()
    {
        $this->login()->forceAccess($this->role, 'collection:update');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($collection->external_id, [
            'fields' => [
                'testfield' => [
                    'slug' => str_repeat('a', 101),
                ],
            ],
        ]);

        $response->assertSchema('UpdateCollection', Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors('fields.testfield.slug');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_contains_characters_other_than_alpha_dash_when_updating_a_collection()
    {
        $this->login()->forceAccess($this->role, 'collection:update');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($collection->external_id, [
            'fields' => [
                'testfield' => [
                    'slug' => 'a b c',
                ],
            ],
        ]);

        $response->assertSchema('UpdateCollection', Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors('fields.testfield.slug');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_field_type_is_not_valid_when_updating_a_collection()
    {
        $this->login()->forceAccess($this->role, 'collection:update');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($collection->external_id, [
            'fields' => [
                'testfield' => [
                    'type' => 'invalid-field-type',
                ],
            ],
        ]);

        $response->assertSchema('UpdateCollection', Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors('fields.testfield.type');
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_validations_field_is_not_an_array_when_updating_a_collection()
    {
        $this->login()->forceAccess($this->role, 'collection:update');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($collection->external_id, [
            'fields' => [
                'testfield' => [
                    'validations' => 'validation-string',
                ],
            ],
        ]);

        $response->assertSchema('UpdateCollection', Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors('fields.testfield.validations');
    }

    /** @test */
    public function it_successfully_executes_the_update_collection_route()
    {
        $this->login()->forceAccess($this->role, 'collection:update');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->makeRequest($collection->external_id, [
            'name' => 'New name',
        ]);

        $response->assertSchema('UpdateCollection', Response::HTTP_OK);
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
        return $this->patch(route('update-collection', $id ?? faker()->numberBetween(1)), $data);
    }
}
