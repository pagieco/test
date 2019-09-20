<?php

namespace Tests\Unit\Policies;

use App\Models\Page;
use App\Policies\PagePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PagePolicyTest extends PolicyTestCase
{
    use RefreshDatabase;

    /**
     * The policy implementation.
     *
     * @var string
     */
    protected $policy = PagePolicy::class;

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_list_the_pages()
    {
        $user = $this->login();

        $this->assertFalse((new PagePolicy)->list($user));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_list_the_pages()
    {
        $user = tap($this->login())->forceAccess($this->role, 'page:list');

        $this->assertTrue((new PagePolicy)->list($user));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_view_a_page()
    {
        $user = $this->login();

        $page = factory(Page::class)->create();

        $this->assertFalse((new PagePolicy)->view($user, $page));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_view_a_page_but_the_page_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'page:view');

        $page = factory(Page::class)->create();

        $this->assertFalse((new PagePolicy)->view($user, $page));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_view_the_page()
    {
        $user = tap($this->login())->forceAccess($this->role, 'page:view');

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new PagePolicy)->view($user, $page));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_create_a_new_page()
    {
        $user = $this->login();

        $this->assertFalse((new PagePolicy)->create($user));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_create_a_new_page()
    {
        $user = tap($this->login())->forceAccess($this->role, 'page:create');

        $this->assertTrue((new PagePolicy)->create($user));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_the_update_a_page()
    {
        $user = $this->login();

        $page = factory(Page::class)->create();

        $this->assertFalse((new PagePolicy)->update($user, $page));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_update_a_page_but_the_page_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'page:update');

        $page = factory(Page::class)->create();

        $this->assertFalse((new PagePolicy)->update($user, $page));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_update_a_page()
    {
        $user = tap($this->login())->forceAccess($this->role, 'page:update');

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new PagePolicy)->update($user, $page));
    }

    /** @test */
    public function it_returns__false_when_the_user_has_no_permission_to_delete_a_page()
    {
        $user = $this->login();

        $page = factory(Page::class)->create();

        $this->assertFalse((new PagePolicy)->delete($user, $page));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_delete_a_page_but_the_page_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'page:delete');

        $page = factory(Page::class)->create();

        $this->assertFalse((new PagePolicy)->delete($user, $page));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_delete_a_page()
    {
        $user = tap($this->login())->forceAccess($this->role, 'page:delete');

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new PagePolicy)->delete($user, $page));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_publish_a_page()
    {
        $user = $this->login();

        $page = factory(Page::class)->create();

        $this->assertFalse((new PagePolicy)->publish($user, $page));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_publish_a_page_but_the_page_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'page:publish');

        $page = factory(Page::class)->create();

        $this->assertFalse((new PagePolicy)->publish($user, $page));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_publish_a_page()
    {
        $user = tap($this->login())->forceAccess($this->role, 'page:publish');

        $page = factory(Page::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new PagePolicy)->publish($user, $page));
    }
}
