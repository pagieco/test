<?php

namespace Tests\Unit\Domains\Collection\Policies;

use Tests\Unit\Policies\PolicyTestCase;
use App\Domains\Collection\Models\Collection;
use App\Domains\Collection\Models\CollectionEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domains\Collection\Policies\CollectionPolicy;

class CollectionPolicyTest extends PolicyTestCase
{
    use RefreshDatabase;

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
    public function it_returns_false_when_the_user_has_no_permission_to_update_a_collection()
    {
        $user = $this->login();

        $collection = factory(Collection::class)->create();

        $this->assertFalse((new CollectionPolicy)->update($user, $collection));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_update_a_collection_but_the_collection_is_not_part_of_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'collection:update');

        $collection = factory(Collection::class)->create();

        $this->assertFalse((new CollectionPolicy)->update($user, $collection));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_update_a_collection()
    {
        $user = tap($this->login())->forceAccess($this->role, 'collection:update');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new CollectionPolicy)->update($user, $collection));
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

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_list_the_collection_entries()
    {
        $user = $this->login();

        $collection = factory(Collection::class)->create();

        $this->assertFalse((new CollectionPolicy)->listEntries($user, $collection));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_list_the_collection_entries_but_the_collection_is_not_part_of_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'collection:list-entries');

        $collection = factory(Collection::class)->create();

        $this->assertFalse((new CollectionPolicy)->listEntries($user, $collection));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_list_the_collection_entries()
    {
        $user = tap($this->login())->forceAccess($this->role, 'collection:list-entries');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new CollectionPolicy)->listEntries($user, $collection));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_update_an_entry()
    {
        $user = $this->login();

        $entry = factory(CollectionEntry::class)->create();

        $this->assertFalse((new CollectionPolicy)->updateEntry($user, $entry));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_update_an_entry_but_the_entry_is_not_part_of_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'collection:update-entry');

        $collection = factory(Collection::class)->create();

        $entry = factory(CollectionEntry::class)->create([
            'collection_id' => $collection->local_id,
        ]);

        $this->assertFalse((new CollectionPolicy)->updateEntry($user, $entry));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_update_an_entry()
    {
        $user = tap($this->login())->forceAccess($this->role, 'collection:update-entry');

        $collection = factory(Collection::class)->create([
            'project_id' => $this->project->id,
        ]);

        $entry = factory(CollectionEntry::class)->create([
            'project_id' => $this->project->id,
            'collection_id' => $collection->local_id,
        ]);

        $this->assertTrue((new CollectionPolicy)->updateEntry($user, $entry));
    }
}
