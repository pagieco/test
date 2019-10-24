<?php

namespace Tests\Unit\Domains\Auth\Listeners;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Domains\Auth\Listeners\LogSuccessfulLogin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domains\Auth\Listeners\LogSuccessfulLogout;

class LogSuccessfulLogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_records_a_succesful_logout_attempt()
    {
        $this->login();

        $request = Request::create(faker()->url);

        $listener = new LogSuccessfulLogout($request);
        $listener->handle(new Logout('api', $this->user));

        $this->assertNull($this->user->authentications->first()->logged_in_at);
        $this->assertNotNull($this->user->authentications->first()->logged_out_at);
    }

    /** @test */
    public function it_records_a_succesful_logout_attempt_to_the_previous_logged_in_attempt()
    {
        $this->login();

        $request = Request::create(faker()->url);

        $listener = new LogSuccessfulLogin($request);
        $listener->handle(new Login('api', $this->user, false));

        $listener = new LogSuccessfulLogout($request);
        $listener->handle(new Logout('api', $this->user));

        $this->user->refresh();

        $this->assertNotNull($this->user->authentications->first()->logged_in_at);
        $this->assertNotNull($this->user->authentications->first()->logged_out_at);
    }
}
