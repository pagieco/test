<?php

namespace Tests\Unit\Domains\Asset\Policies;

use Tests\Unit\Policies\PolicyTestCase;
use App\Domains\Asset\Models\AssetFolder;
use App\Domains\Asset\Policies\AssetFolderPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssetFolderPolicyTest extends PolicyTestCase
{
    use RefreshDatabase;

    /**
     * The policy implementation.
     *
     * @var string
     */
    protected $policy = AssetFolderPolicy::class;

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_list_the_folders()
    {
        $this->login();

        $this->assertFalse((new AssetFolderPolicy)->list($this->user));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_list_the_folders()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset-folder:list');

        $this->assertTrue((new AssetFolderPolicy)->list($user));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_view_a_folder()
    {
        $user = $this->login();

        $folder = factory(AssetFolder::class)->create();

        $this->assertFalse((new AssetFolderPolicy)->view($user, $folder));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_view_a_folder_but_the_folder_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset-folder:view');

        $folder = factory(AssetFolder::class)->create();

        $this->assertFalse((new AssetFolderPolicy)->view($user, $folder));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_view_the_folder()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset-folder:view');

        $folder = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new AssetFolderPolicy)->view($user, $folder));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_update_a_folder()
    {
        $user = $this->login();

        $folder = factory(AssetFolder::class)->create();

        $this->assertFalse((new AssetFolderPolicy)->update($user, $folder));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_update_a_folder_but_the_folder_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset-folder:update');

        $folder = factory(AssetFolder::class)->create();

        $this->assertFalse((new AssetFolderPolicy)->update($user, $folder));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_update_the_folder()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset-folder:update');

        $folder = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new AssetFolderPolicy)->update($user, $folder));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_delete_a_folder()
    {
        $user = $this->login();

        $folder = factory(AssetFolder::class)->create();

        $this->assertFalse((new AssetFolderPolicy)->delete($user, $folder));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_delete_a_folder_but_the_folder_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset-folder:delete');

        $folder = factory(AssetFolder::class)->create();

        $this->assertFalse((new AssetFolderPolicy)->delete($user, $folder));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_delete_the_folder()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset-folder:delete');

        $folder = factory(AssetFolder::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new AssetFolderPolicy)->delete($user, $folder));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_create_a_new_folder()
    {
        $user = $this->login();

        $this->assertFalse((new AssetFolderPolicy)->create($user));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_create_a_new_folder()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset-folder:create');

        $this->assertTrue((new AssetFolderPolicy)->create($user));
    }
}
