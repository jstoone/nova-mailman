<?php

namespace Jstoone\Mailman\Tests;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;
use Jstoone\Mailman\MailmanServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public static $mailDriver = 'mailman';

    public function setUp()
    {
        parent::setUp();

        Route::middlewareGroup('nova', []);
    }

    public function tearDown()
    {
        app(Filesystem::class)->deleteDirectory('mailman');

        parent::tearDown();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('filesystems.disks.local', [
            'driver' => 'local',
            'root'   => __DIR__ . '/temp',
        ]);
    }

    protected function getPackageProviders($app)
    {
        $app['config']->set('mail.driver', self::$mailDriver);

        return [
            MailmanServiceProvider::class,
        ];
    }
}
