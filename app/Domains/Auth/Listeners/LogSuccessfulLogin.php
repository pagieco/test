<?php

namespace App\Domains\Auth\Listeners;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use App\Domains\Auth\Models\AuthenticationLog;
use App\Domains\Auth\Notifications\NewDeviceNotification;

class LogSuccessfulLogin
{
    /**
     * The current request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected Request $request;

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
        /** @var \App\Domains\User\Models\User $user */
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
