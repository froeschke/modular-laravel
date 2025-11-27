<?php

namespace Froeschke\ModularLaravel\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Froeschke\ModularLaravel\ModularLaravelServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            ModularLaravelServiceProvider::class,
        ];
    }
}
