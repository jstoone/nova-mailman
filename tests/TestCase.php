<?php

namespace Jstoone\Mailman\Tests;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;
use Jstoone\Mailman\Mailer\MailmanTransport;
use Jstoone\Mailman\MailmanServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Swift_Message;

abstract class TestCase extends Orchestra
{
    /** @var string */
    public static $mailDriver = 'mailman';

    /** @var MailmanTransport */
    private $transport;

    public function setUp()
    {
        parent::setUp();

        $this->transport = $this->app->make(MailmanTransport::class);
    }

    public function tearDown()
    {
        app(Filesystem::class)->deleteDirectory('mailman');

        parent::tearDown();
    }

    protected function getEnvironmentSetUp($app)
    {
        Route::middlewareGroup('nova', []);
    }

    protected function getPackageProviders($app)
    {
        $app['config']->set('mail.driver', self::$mailDriver);
        $app['config']->set('filesystems.disks.local', [
            'driver' => 'local',
            'root'   => __DIR__ . '/temp',
        ]);

        return [
            MailmanServiceProvider::class,
        ];
    }

    protected function sendMail(string $subject, string $recipient): Swift_Message
    {
        $message = new Swift_Message($subject, 'Mail Body');
        $message->setTo($recipient);

        $this->transport->send($message);

        return $message;
    }
}
