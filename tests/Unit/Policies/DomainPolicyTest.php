<?php

namespace Tests\Unit\Policies;

use App\Models\Domain;
use App\Policies\DomainPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DomainPolicyTest extends PolicyTestCase
{
    use RefreshDatabase;

    /**
     * The policy implementation.
     *
     * @var string
     */
    protected $policy = DomainPolicy::class;

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_list_the_domains()
    {
        $this->login();

        $this->assertFalse((new DomainPolicy)->list($this->user));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_list_the_domains()
    {
        $user = tap($this->login())->forceAccess($this->role, 'domain:list');

        $this->assertTrue((new DomainPolicy)->list($user));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_view_a_domain()
    {
        $user = $this->login();

        $domain = factory(Domain::class)->create();

        $this->assertFalse((new DomainPolicy)->view($user, $domain));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_view_a_domain_but_the_domain_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'domain:view');

        $domain = factory(Domain::class)->create();

        $this->assertFalse((new DomainPolicy)->view($user, $domain));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_view_the_domain()
    {
        $user = tap($this->login())->forceAccess($this->role, 'domain:view');

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new DomainPolicy)->view($user, $domain));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_update_a_domain()
    {
        $user = $this->login();

        $domain = factory(Domain::class)->create();

        $this->assertFalse((new DomainPolicy)->update($user, $domain));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_update_a_domain_but_the_domain_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'domain:update');

        $domain = factory(Domain::class)->create();

        $this->assertFalse((new DomainPolicy)->update($user, $domain));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_update_the_domain()
    {
        $user = tap($this->login())->forceAccess($this->role, 'domain:update');

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new DomainPolicy)->update($user, $domain));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_delete_a_domain()
    {
        $user = $this->login();

        $domain = factory(Domain::class)->create();

        $this->assertFalse((new DomainPolicy)->delete($user, $domain));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_delete_a_domain_but_the_domain_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'domain:delete');

        $domain = factory(Domain::class)->create();

        $this->assertFalse((new DomainPolicy)->delete($user, $domain));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_delete_the_domain()
    {
        $user = tap($this->login())->forceAccess($this->role, 'domain:delete');

        $domain = factory(Domain::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new DomainPolicy)->delete($user, $domain));
    }
}
