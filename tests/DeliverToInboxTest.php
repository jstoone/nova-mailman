<?php

namespace Jstoone\Mailman\Tests;

use Jstoone\Mailman\GenerateMailIdentifier;
use Jstoone\Mailman\MailSheet;

class DeliverToInboxTest extends TestCase
{
    /** @test */
    public function it_stores_emails_as_sheets()
    {
        $this->app->instance(GenerateMailIdentifier::class, function () {
            return 'unique-identifier';
        });

        $this->sendMail('Mail Subject', 'john@example.com');

        $sheet = sheets()->get('unique-identifier');
        $this->assertInstanceOf(MailSheet::class, $sheet);
        $this->assertEquals(
            [
                'slug'        => 'unique-identifier',
                'subject'     => 'Mail Subject',
                'recipient'   => 'john@example.com',
                'sent_at'     => now(),
                'link'        => route('nova-mailman.show', 'unique-identifier'),
                'contents'    => "<p>Mail Body</p>\n",
            ],
            $sheet->toArray()
        );
    }
}
