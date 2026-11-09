<?php

declare(strict_types=1);

namespace Tests;

use Juaniquillo\BackendComponents\BackendComponentsServiceProvider;
use Juaniquillo\InputComponentAction\InputComponentActionServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            InputComponentActionServiceProvider::class,
            BackendComponentsServiceProvider::class,
        ];
    }
}
