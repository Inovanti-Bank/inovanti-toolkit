<?php

namespace InovantiBank\Toolkit\Providers;

use Illuminate\Support\ServiceProvider;
use InovantiBank\Toolkit\Support\ToolkitManager;

class ToolkitServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('toolkit', function () {
            return new ToolkitManager;
        });
    }

    public function boot()
    {
        //
    }
}
