<?php

namespace Jstoone\Mailman\Tests;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Mail;
use Jstoone\Mailman\MailmanServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Sheets\SheetsServiceProvider;

abstract class TestCase extends Orchestra
{
    public function tearDown()
    {
        app(Filesystem::class)->deleteDirectory(
            __DIR__ . '/temp/mailman',
            false
        );

        parent::tearDown();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['router']->middlewareGroup('nova', []);

        $app['config']->set('mail.driver', 'array');

        $app['config']->set('filesystems.disks.local', [
            'driver' => 'local',
            'root'   => __DIR__ . '/temp/mailman',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            SheetsServiceProvider::class,
            MailmanServiceProvider::class,
        ];
    }

    protected function sendMail(string $subject, string $recipient): void
    {
        Mail::raw('Mail Body', function ($message) use ($subject, $recipient) {
            $message->from('jstoone@example.com')
                ->to($recipient)
                ->subject($subject);
        });
    }
}
