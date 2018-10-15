<?php

namespace Jstoone\Mailman\Tests;

use Illuminate\Support\Facades\Route;
use Jstoone\Mailman\MailmanServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();

        Route::middlewareGroup('nova', []);
    }

    protected function getPackageProviders($app)
    {
        return [
            MailmanServiceProvider::class,
        ];
    }
}
