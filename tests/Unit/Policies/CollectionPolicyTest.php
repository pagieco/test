<?php

namespace Tests\Unit\Policies;

use App\Models\Collection;
use Tests\RefreshCollections;
use App\Policies\CollectionPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CollectionPolicyTest extends PolicyTestCase
{
    use RefreshDatabase;
    use RefreshCollections;

    /**
     * The policy implementation.
     *
     * @var string
     */
    protected $policy = CollectionPolicy::class;

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_list_the_collections()
    {
        $user = $this->login();

        $this->assertFalse((new CollectionPolicy)->list($user));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_list_the_collections()
    {
        $user = tap($this->login())->forceAccess($this->role, 'collection:list');

        $this->assertTrue((new CollectionPolicy)->list($user));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_view_a_collection()
    {
        $user = $this->login();

        $collection = factory(Collection::class)->create();

        $this->assertFalse((new CollectionPolicy)->view($user, $collection));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_view_a_collection_but_the_collection_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'collection:view');

        $collection = factory(Collection::class)->create();

        $this->assertFalse((new CollectionPolicy)->view($user, $collection));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_view_the_collection()
    {
        $user = tap($this->login())->forceAccess($this->role, 'collection:view');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new CollectionPolicy)->view($user, $collection));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_the_delete_a_collection()
    {
        $user = $this->login();

        $collection = factory(Collection::class)->create();

        $this->assertFalse((new CollectionPolicy)->delete($user, $collection));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_delete_a_collection_but_the_collection_is_not_part_of_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'collection:delete');

        $collection = factory(Collection::class)->create();

        $this->assertFalse((new CollectionPolicy)->delete($user, $collection));
    }

    /** @test */
    public function it_returns_true_when_the_use_has_permission_to_delete_a_collection()
    {
        $user = tap($this->login())->forceAccess($this->role, 'collection:delete');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new CollectionPolicy)->delete($user, $collection));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_create_a_new_collection_entry()
    {
        $user = $this->login();

        $collection = factory(Collection::class)->create();

        $this->assertFalse((new CollectionPolicy)->createEntry($user, $collection));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_create_a_new_collection_entry_but_the_collection_is_not_part_of_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'collection:create-entry');

        $collection = factory(Collection::class)->create();

        $this->assertFalse((new CollectionPolicy)->createEntry($user, $collection));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_create_a_new_collection()
    {
        $user = tap($this->login())->forceAccess($this->role, 'collection:create-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new CollectionPolicy)->createEntry($user, $collection));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_delete_the_collection_entry()
    {
        $user = $this->login();

        $collection = factory(Collection::class)->create();

        $this->assertFalse((new CollectionPolicy)->deleteEntry($user, $collection));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_delete_a_collection_entry_but_the_collection_entry_is_not_part_of_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'collection:delete-entry');

        $collection = factory(Collection::class)->create();

        $this->assertFalse((new CollectionPolicy)->deleteEntry($user, $collection));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_delete_a_collection_entry()
    {
        $user = tap($this->login())->forceAccess($this->role, 'collection:delete-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new CollectionPolicy)->deleteEntry($user, $collection));
    }
}
