<?php

namespace Jstoone\Mailman\Tests\Http\Controllers;

use Jstoone\Mailman\GenerateMailIdentifier;
use Jstoone\Mailman\Tests\TestCase;

class MailmanControllerTest extends TestCase
{
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

        $this->withoutExceptionHandling();
        $response = $this->get(route('nova-mailman.index'))
            ->assertSuccessful()
            ->assertJson([
                [
                    'id'        => 'unique-mail-identifier',
                    'recipient' => $recipient,
                    'subject'   => $subject,
                    'sent_at'   => time(),
                    'link'      => route('nova-mailman.show', 'unique-mail-identifier'),
                ],
            ]);
    }

    /** @test */
    public function it_gives_empty_response_upon_missing_directory()
    {
        $this->get(route('nova-mailman.index'))
            ->assertSuccessful()
            ->assertJson([]);
    }

    /** @test */
    public function it_can_return_the_view_for_a_given_mail()
    {
        $this->withoutExceptionHandling();
        $this->app->instance(GenerateMailIdentifier::class, function () {
            return 'unique-mail-identifier';
        });

        $this->sendMail(
            $subject = 'Mail Subject',
            $recipient = 'john@example.com'
        );

        $this->get(route('nova-mailman.show', 'unique-mail-identifier'))
            ->assertSuccessful()
            ->assertViewIs('nova-mailman-mails::unique-mail-identifier');
    }
}
