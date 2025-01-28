<?php

namespace Tests;

use InovantiBank\Toolkit\Providers\ToolkitServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ToolkitServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
    }
}
