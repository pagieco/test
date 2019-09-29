<?php

namespace App\Providers;

use App\Macros\RequestMixin;
use Illuminate\Http\Request;
use App\Models\ModelObservers;
use App\Macros\TestResposeMixin;
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

        require __DIR__.'/../Support/helpers.php';
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
        TestResponse::mixin(new TestResposeMixin);
        Request::mixin(new RequestMixin);
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
