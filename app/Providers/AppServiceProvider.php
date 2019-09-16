<?php

namespace App\Providers;

use Illuminate\Http\Request;
use App\Macros\RequestMacros;
use App\Models\ModelObservers;
use App\Macros\TestResposeMacros;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Testing\TestResponse;

class AppServiceProvider extends ServiceProvider
{
    use ModelObservers;

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
        $this->registerModelObservers();
    }

    protected function registerApplicationMixins()
    {
        TestResponse::mixin(new TestResposeMacros);
        Request::mixin(new RequestMacros);
    }

    /**
     * Register the model observers.
     *
     * @return void
     */
    public function registerModelObservers(): void
    {
        foreach ($this->observers as $model => $observer) {
            $model::observe($observer);
        }
    }
}
