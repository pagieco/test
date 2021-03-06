<?php

namespace Tests\Unit\Domains\Automation\Policies;

use Tests\Unit\Policies\PolicyTestCase;
use App\Domains\Automation\Models\Automation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domains\Automation\Policies\AutomationPolicy;

class AutomationPolicyTest extends PolicyTestCase
{
    use RefreshDatabase;

    /**
     * The policy implementation.
     *
     * @var string
     */
    protected $policy = AutomationPolicy::class;

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_list_the_automations()
    {
        $user = $this->login();

        $this->assertFalse((new AutomationPolicy)->list($user));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_list_the_automations()
    {
        $user = tap($this->login())->forceAccess($this->role, 'automation:list');

        $this->assertTrue((new AutomationPolicy)->list($user));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_view_an_automation()
    {
        $user = $this->login();

        $automation = factory(Automation::class)->create();

        $this->assertFalse((new AutomationPolicy)->view($user, $automation));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_view_an_automation_but_the_automation_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'automation:view');

        $automation = factory(Automation::class)->create();

        $this->assertFalse((new AutomationPolicy)->view($user, $automation));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_view_the_automation()
    {
        $user = tap($this->login())->forceAccess($this->role, 'automation:view');

        $automation = factory(Automation::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new AutomationPolicy)->view($user, $automation));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_delete_an_automation()
    {
        $user = $this->login();

        $automation = factory(Automation::class)->create();

        $this->assertFalse((new AutomationPolicy)->delete($user, $automation));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_delete_an_automation_but_the_automation_is_not_part_of_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'automation:delete');

        $automation = factory(Automation::class)->create();

        $this->assertFalse((new AutomationPolicy)->delete($user, $automation));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_delete_an_automation()
    {
        $user = tap($this->login())->forceAccess($this->role, 'automation:delete');

        $automation = factory(Automation::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new AutomationPolicy)->delete($user, $automation));
    }
}
