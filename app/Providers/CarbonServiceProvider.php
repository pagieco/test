<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class CarbonServiceProvider extends ServiceProvider
{
    /**
     * Register the carbon service provider.
     *
     * @return void
     */
    public function register()
    {
        Carbon::serializeUsing(function ($carbon) {
            return $carbon->toIso8601String();
        });
    }
}
