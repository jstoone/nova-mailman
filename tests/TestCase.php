<?php

namespace Jstoone\Mailman\Tests;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Mail;
use Jstoone\Mailman\MailmanServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function tearDown()
    {
        app(Filesystem::class)->deleteDirectory('mailman');

        parent::tearDown();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['router']->middlewareGroup('nova', []);

        $app['config']->set('mail.driver', 'array');

        $app['config']->set('filesystems.disks.local', [
            'driver' => 'local',
            'root'   => __DIR__ . '/temp',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
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
