<?php

namespace Jstoone\Mailman\Tests;

use Illuminate\Mail\Events\MessageSent;

class MailmanServiceProviderTest extends TestCase
{
    /** @test */
    public function it_registers_a_mail_sent_listener()
    {
        $this->assertCount(1, $this->app['events']->getListeners(MessageSent::class));
    }
}
