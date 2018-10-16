<?php

namespace Jstoone\Mailman\Tests\Mailer;

use Jstoone\Mailman\Mailer\MailmanTransport;
use Jstoone\Mailman\Tests\TestCase;

class MailProviderTest extends TestCase
{
    /** @test */
    public function it_registers_the_mailman_transporter()
    {
        $mailer = $this->app['mailer'];

        $this->assertInstanceOf(
            MailmanTransport::class,
            $mailer->getSwiftMailer()->getTransport()
        );
    }
}
