<?php

namespace Jstoone\Mailman\Tests;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\View\View;
use Jstoone\Mailman\GenerateMailIdentifier;

class DeliverToInboxTest extends TestCase
{
    /** @test */
    public function it_creates_a_directory_for_storing_emails()
    {
        $this->sendMail('Mail Subject', 'john@example.com');

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

        $this->sendMail('Mail Subject', 'john@example.com');

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

        $this->sendMail('Mail Subject', 'john@example.com');
        $file = app(Filesystem::class)->get('mailman/unique-identifier.json');

        $this->assertEquals(
            [
                'id'        => 'unique-identifier',
                'subject'   => 'Mail Subject',
                'recipient' => 'john@example.com',
                'sent_at'   => (string) now(),
                'link'      => route('nova-mailman.show', 'unique-identifier'),
            ],
            json_decode($file, true)
        );
    }
}
