<?php

namespace App\Providers;

use App\Macros\TestResposeMacros;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Testing\TestResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerApplicationMixins();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    protected function registerApplicationMixins()
    {
        TestResponse::mixin(new TestResposeMacros);
    }
}
