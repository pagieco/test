<?php

namespace Tests\Unit\Listeners;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Models\AuthenticationLog;
use Illuminate\Auth\Events\Login;
use App\Listeners\LogSuccessfulLogin;
use App\Notifications\NewDeviceNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogSuccessfulLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_records_a_successful_login_attempt()
    {
        Notification::fake();

        $this->login();

        $request = Request::create(faker()->url);

        $listener = new LogSuccessfulLogin($request);
        $listener->handle(new Login('api', $this->user, false));

        $this->assertCount(1, $this->user->authentications);

        Notification::assertNotSentTo([$this->user], NewDeviceNotification::class);
    }

    /** @test */
    public function it_notifies_the_user_when_the_user_logs_in_with_another_device()
    {
        Notification::fake();

        $this->login();

        factory(AuthenticationLog::class)->create([
            'user_id' => $this->user->id,
        ]);

        $request = Request::create(faker()->url);

        $listener = new LogSuccessfulLogin($request);
        $listener->handle(new Login('api', $this->user, false));

        Notification::assertSentTo([$this->user], NewDeviceNotification::class);
    }
}
