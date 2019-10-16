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

    /**
     * @throws \ReflectionException
     */
    protected function registerApplicationMixins()
    {
        Request::mixin(new RequestMixin);
        TestResponse::mixin(new TestResposeMixin);
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
