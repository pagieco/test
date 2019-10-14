<?php

namespace App\Listeners;

use Illuminate\Http\Request;
use App\Models\AuthenticationLog;
use Illuminate\Auth\Events\Login;
use App\Notifications\NewDeviceNotification;

class LogSuccessfulLogin
{
    /**
     * The current request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create the event listener.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;

        $ipAddress = $this->request->ip();
        $userAgent = $this->request->userAgent();

        $known = $user->authentications()->where([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ])->first();

        $count = $user->authentications->count();

        $log = new AuthenticationLog([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'logged_in_at' => now(),
        ]);

        $user->authentications()->save($log);

        $user->refresh();

        if ($count > 0 && ! $known) {
            $user->notify(new NewDeviceNotification($log));
        }
    }
}