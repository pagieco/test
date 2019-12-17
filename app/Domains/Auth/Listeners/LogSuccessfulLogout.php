<?php

namespace App\Domains\Auth\Listeners;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\OtherDeviceLogout;
use App\Domains\Auth\Models\AuthenticationLog;

class LogSuccessfulLogout
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
     * @param  \Illuminate\Auth\Events\Logout $event
     * @return void
     */
    public function handle(Logout $event)
    {
        if (! $event->user || $event instanceof OtherDeviceLogout) {
            return;
        }

        $ipAddress = $this->request->ip();
        $userAgent = $this->request->userAgent();

        $log = $event->user->authentications()->where([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ])->first();

        if (! $log) {
            $log = new AuthenticationLog([
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
            ]);
        }

        $log->logged_out_at = now();

        $event->user->authentications()->save($log);
    }
}
