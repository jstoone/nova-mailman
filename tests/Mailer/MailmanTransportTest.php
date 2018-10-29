<?php

namespace Jstoone\Mailman\Tests\Mailer;

use Illuminate\Contracts\Filesystem\Filesystem;
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
    public function it_stores_emails_as_html_files()
    {
        $message = $this->sendMail('Mail Subject', 'john@example.com');

        $file = app(Filesystem::class)->get('mailman/' . time() . '.html');

        $this->assertEquals('Mail Body', $file);
    }

    /** @test */
    public function it_stores_email_metadata_in_a_json_file()
    {
        $message = $this->sendMail('Mail Subject', 'john@example.com');

        $file = app(Filesystem::class)->get(
            $path = 'mailman/' . time() . '.json'
        );

        $this->assertEquals(
            [
                'recipient' => 'john@example.com',
                'subject'   => $message->getSubject(),
                'sent_at'   => time(),
                'content'   => 'mailman/' . time() . '.html',
            ],
            json_decode($file, true)
        );
    }
}
