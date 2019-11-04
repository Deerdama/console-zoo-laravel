<?php

namespace Deerdama\ConsoleZoo;

use Illuminate\Support\ServiceProvider;

class ConsoleZooServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/zoo.php' => config_path('zoo.php'),
        ], 'config');
    }

    public function register()
    {
        $this->app->singleton('command.zoo:options', function () {
            return new ShowOptions;
        });

        $this->mergeConfigFrom(
            __DIR__ . '/../config/zoo.php', 'zoo'
        );

        $this->commands(['command.zoo:options']);
    }
}