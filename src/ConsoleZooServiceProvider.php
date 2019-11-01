<?php

namespace Deerdama\ConsoleZoo;

use Illuminate\Support\ServiceProvider;

class ConsoleZooServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('command.zoo:available-options', function () {
            return new ShowOptions;
        });

        $this->commands(['command.zoo:available-options']);
    }
}