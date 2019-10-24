<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\OtherDeviceLogout;
use App\Domains\Auth\Listeners\LogSuccessfulLogin;
use App\Domains\User\Listeners\FetchUsersGravatar;
use App\Domains\Auth\Listeners\LogSuccessfulLogout;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            FetchUsersGravatar::class,
        ],

        Login::class => [
            LogSuccessfulLogin::class,
        ],

        Logout::class => [
            LogSuccessfulLogout::class,
        ],

        OtherDeviceLogout::class => [
            LogSuccessfulLogout::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
