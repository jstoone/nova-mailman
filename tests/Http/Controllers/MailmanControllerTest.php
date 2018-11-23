<?php

namespace Jstoone\Mailman\Tests\Http\Controllers;

use Jstoone\Mailman\Tests\TestCase;

class MailmanControllerTest extends TestCase
{
    /** @test */
    public function it_returns_emails()
    {
        $this->withoutExceptionHandling();
        $this->sendMail(
            $subject = 'Mail Subject',
            $recipient = 'john@example.com'
        );

        $response = $this->get('nova-vendor/jstoone/nova-mailman/mailman')
            ->assertSuccessful()
            ->assertJson([
                [
                    'recipient' => $recipient,
                    'subject'   => $subject,
                    'sent_at'   => time(),
                    'content'   => asset('mailman/' . time() . '.html'),
                ],
            ]);
    }

    /** @test */
    public function it_gives_empty_response_upon_missing_directory(): void
    {
        $response = $this->get('nova-vendor/jstoone/nova-mailman/mailman')
            ->assertSuccessful()
            ->assertJson([]);
    }
}
