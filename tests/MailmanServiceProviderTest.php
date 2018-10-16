<?php

namespace Jstoone\Mailman\Tests;

use Jstoone\Mailman\Mailer\MailProvider;

class MailmanServiceProviderTest extends TestCase
{
    /** @test */
    public function it_registers_the_mailman_mail_service_provider()
    {
        $this->assertArrayHasKey(
            MailProvider::class,
            $this->app->getLoadedProviders()
        );
    }

    /** @test */
    public function it_only_registers_mail_provider_when_using_mailman_driver()
    {
        static::$mailDriver = 'failman';

        $app = $this->createApplication();

        $this->assertArrayNotHasKey(
            MailProvider::class,
            $app->getLoadedProviders()
        );
    }
}
