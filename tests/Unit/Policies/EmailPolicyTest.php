<?php

namespace Tests\Unit\Policies;

use App\Models\Email;
use App\Policies\EmailPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailPolicyTest extends PolicyTestCase
{
    use RefreshDatabase;

    /**
     * The policy implementation.
     *
     * @var string
     */
    protected $policy = EmailPolicy::class;

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_list_the_emails()
    {
        $user = $this->login();

        $this->assertFalse((new EmailPolicy)->list($user));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_list_the_emails()
    {
        $user = tap($this->login())->forceAccess($this->role, 'email:list');

        $this->assertTrue((new EmailPolicy)->list($user));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_no_permission_to_view_an_email()
    {
        $user = $this->login();

        $email = factory(Email::class)->create();

        $this->assertFalse((new EmailPolicy)->view($user, $email));
    }

    /** @test */
    public function it_returns_false_when_the_user_has_permission_to_view_an_email_but_the_email_is_not_from_the_current_project()
    {
        $user = tap($this->login())->forceAccess($this->role, 'email:view');

        $email = factory(Email::class)->create();

        $this->assertFalse((new EmailPolicy)->view($user, $email));
    }

    /** @test */
    public function it_returns_true_when_the_user_has_permission_to_view_the_email()
    {
        $user = tap($this->login())->forceAccess($this->role, 'email:view');

        $email = factory(Email::class)->create([
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue((new EmailPolicy)->view($user, $email));
    }
}
