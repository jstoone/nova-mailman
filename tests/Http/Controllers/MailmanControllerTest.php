<?php

namespace Jstoone\Mailman\Tests\Http\Controllers;

use Jstoone\Mailman\GenerateMailIdentifier;
use Jstoone\Mailman\Tests\TestCase;

class MailmanControllerTest extends TestCase
{
    const MAIL_ROUTE = 'nova-vendor/jstoone/nova-mailman/mail';

    /** @test */
    public function it_returns_emails()
    {
        $this->app->instance(GenerateMailIdentifier::class, function () {
            return 'unique-mail-identifier';
        });

        $this->sendMail(
            $subject = 'Mail Subject',
            $recipient = 'john@example.com'
        );

        $response = $this->get(self::MAIL_ROUTE)
            ->assertSuccessful()
            ->assertJson([
                [
                    'identifier' => 'unique-mail-identifier',
                    'recipient'  => $recipient,
                    'subject'    => $subject,
                    'sent_at'    => time(),
                ],
            ]);
    }

    /** @test */
    public function it_gives_empty_response_upon_missing_directory(): void
    {
        $response = $this->get(self::MAIL_ROUTE)
            ->assertSuccessful()
            ->assertJson([]);
    }
}
