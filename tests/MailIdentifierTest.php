<?php

namespace Jstoone\Mailman\Tests;

use Jstoone\Mailman\GenerateMailIdentifier;
use Jstoone\Mailman\MailIdentifier;

class MailIdentifierTest extends TestCase
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
