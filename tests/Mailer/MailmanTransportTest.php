<?php

namespace Jstoone\Mailman\Tests\Mailer;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\View\View;
use Jstoone\Mailman\GenerateMailIdentifier;
use Jstoone\Mailman\Mailer\MailmanTransport;
use Jstoone\Mailman\Tests\TestCase;
use Swift_Message;

class MailmanTransportTest extends TestCase
{
    /** @test */
    public function it_creates_a_directory_for_storing_emails()
    {
        $message = new Swift_Message('Mail Subject', 'Mail Body');
        $message->setTo('john@example.com');

        $transport = $this->app->make(MailmanTransport::class);

        $transport->send($message);

        $this->assertTrue(
            app(Filesystem::class)->exists('mailman')
        );
    }

    /** @test */
    public function it_stores_emails_as_blade_views()
    {
        $this->app->instance(GenerateMailIdentifier::class, function () {
            return 'unique-identifier';
        });

        $message = $this->sendMail('Mail Subject', 'john@example.com');

        $view = view('nova-mailman-mails::unique-identifier');
        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('Mail Body', $view->render());
    }

    /** @test */
    public function it_stores_email_metadata_in_a_json_file()
    {
        $this->app->instance(GenerateMailIdentifier::class, function () {
            return 'unique-identifier';
        });

        $message = $this->sendMail('Mail Subject', 'john@example.com');
        $file = app(Filesystem::class)->get('mailman/unique-identifier.json');

        $this->assertEquals(
            [
                'id'        => 'unique-identifier',
                'subject'   => $message->getSubject(),
                'recipient' => 'john@example.com',
                'sent_at'   => time(),
                'link'      => route('nova-mailman.show', 'unique-identifier'),
            ],
            json_decode($file, true)
        );
    }
}
