<?php

namespace Jstoone\Mailman\Tests\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Jstoone\Mailman\GenerateMailIdentifier;
use Jstoone\Mailman\Tests\TestCase;

class MailmanControllerTest extends TestCase
{
    /** @test */
    public function it_can_return_an_index_of_emails()
    {
        $this->app->instance(GenerateMailIdentifier::class, function () {
            return 'unique-mail-identifier';
        });

        $this->sendMail(
            $subject = 'Mail Subject',
            $recipient = 'john@example.com'
        );

        $this->withoutExceptionHandling();
        $this->get(route('nova-mailman.index'))
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
    public function it_gives_an_empty_index_upon_missing_directory()
    {
        $this->get(route('nova-mailman.index'))
            ->assertSuccessful()
            ->assertJson([]);
    }

    /** @test */
    public function it_can_return_the_view_for_a_given_mail()
    {
        $this->app->instance(GenerateMailIdentifier::class, function () {
            return 'unique-mail-identifier';
        });

        $this->sendMail('Mail Subject', 'john@example.com');

        $this->get(route('nova-mailman.show', 'unique-mail-identifier'))
            ->assertSuccessful()
            ->assertViewIs('nova-mailman-mails::unique-mail-identifier');
    }

    /** @test */
    public function it_can_delete_a_given_mail()
    {
        $this->app->instance(GenerateMailIdentifier::class, function () {
            return 'unique-mail-identifier';
        });

        $this->sendMail('Mail Subject', 'john@example.com');

        $this->withoutExceptionHandling();
        $this->delete(route('nova-mailman.destroy', 'unique-mail-identifier'))
            ->assertSuccessful();

        $this->assertFalse(
            View::exists('nova-mailman-mails::unique-mail-identifier'),
            'Expected mail view file to be missing, but it is not.'
        );

        $this->assertFalse(
            Storage::exists('mailman/unique-mail-identifier.json'),
            'Expected mail metadata file to be missing, but it is not.'
        );
    }
}
