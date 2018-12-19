<?php

namespace Jstoone\Mailman\Tests;

use Illuminate\Mail\Events\MessageSent;
use Jstoone\Mailman\MailSheet;

class MailmanServiceProviderTest extends TestCase
{
    /** @test */
    public function it_registers_a_sheets_collection()
    {
        $expected = [
            'mailman' => [
                'disk'        => config('mailman.disk'),
                'sheet_class' => MailSheet::class,
            ],
        ];

        $this->assertEquals($expected, config('sheets.collections'));
    }

    /** @test */
    public function it_registers_a_mail_sent_listener()
    {
        $this->assertCount(1, $this->app['events']->getListeners(MessageSent::class));
    }
}
