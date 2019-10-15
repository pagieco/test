<?php

namespace App\Database;

use App\Database\Connection\ConnectionFactory;
use Illuminate\Database\DatabaseServiceProvider;

class ServiceProvider extends DatabaseServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->singleton('db.factory', function ($app) {
            return new ConnectionFactory($app);
        });
    }
}
