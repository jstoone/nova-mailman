<?php

namespace Jstoone\Mailman\Tests\Mailer;

use Jstoone\Mailman\GenerateMailIdentifier;
use Jstoone\Mailman\Mailer\MailIdentifier;
use Jstoone\Mailman\Tests\TestCase;

class MailmanControllerTest extends TestCase
{
    /** @test */
    public function it_can_generate_a_mail_identifier()
    {
        $this->app->instance(GenerateMailIdentifier::class, function () {
            return 'a-mail-identifier';
        });

        $this->assertEquals('a-mail-identifier', MailIdentifier::generate());
    }
}
