<?php

namespace Tests\Unit\Policies;

use App\Models\Asset;
use App\Policies\AssetPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssetPolicyTest extends PolicyTestCase
{
    use RefreshDatabase;

    /**
     * The policy implementation.
     *
     * @var string
     */
    protected $policy = AssetPolicy::class;

    /**
     * The policy list.
     *
     * @var array
     */
    protected $policyList = [
        'asset:list',
        'asset:view',
        'asset:upload',
        'asset:delete',
    ];

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_list_the_assets()
    {
        $this->login();

        $this->assertFalse((new AssetPolicy)->list($this->user));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_list_the_assets()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset:list');

        $this->assertTrue((new AssetPolicy)->list($user));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_view_an_asset()
    {
        $user = $this->login();

        $asset = factory(Asset::class)->create();

        $this->assertFalse((new AssetPolicy)->view($user, $asset));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_view_an_asset_but_the_asset_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset:view');

        $asset = factory(Asset::class)->create();

        $this->assertFalse((new AssetPolicy)->view($user, $asset));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_view_an_asset()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset:view');

        $asset = factory(Asset::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new AssetPolicy)->view($user, $asset));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_upload_an_asset()
    {
        $user = $this->login();

        $this->assertFalse((new AssetPolicy)->upload($user));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_upload_an_asset()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset:upload');

        $this->assertTrue((new AssetPolicy)->upload($user));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_access_to_delete_an_asset()
    {
        $user = $this->login();

        $asset = factory(Asset::class)->create();

        $this->assertFalse((new AssetPolicy)->delete($user, $asset));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_access_to_delete_an_asset_but_the_asset_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset:delete');

        $asset = factory(Asset::class)->create();

        $this->assertFalse((new AssetPolicy)->delete($user, $asset));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_delete_the_asset()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset:delete');

        $asset = factory(Asset::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new AssetPolicy)->delete($user, $asset));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_access_to_move_an_asset()
    {
        $user = $this->login();

        $asset = factory(Asset::class)->create();

        $this->assertFalse((new AssetPolicy)->move($user, $asset));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_access_to_move_an_asset_but_the_asset_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset:move');

        $asset = factory(Asset::class)->create();

        $this->assertFalse((new AssetPolicy)->move($user, $asset));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_move_an_asset()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset:move');

        $asset = factory(Asset::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new AssetPolicy)->move($user, $asset));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_access_to_update_an_asset()
    {
        $user = $this->login();

        $asset = factory(Asset::class)->create();

        $this->assertFalse((new AssetPolicy)->update($user, $asset));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_access_to_update_an_asset_but_the_asset_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset:update');

        $asset = factory(Asset::class)->create();

        $this->assertFalse((new AssetPolicy)->update($user, $asset));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_update_an_asset()
    {
        $user = tap($this->login())->forceAccess($this->role, 'asset:update');

        $asset = factory(Asset::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new AssetPolicy)->update($user, $asset));
    }
}
