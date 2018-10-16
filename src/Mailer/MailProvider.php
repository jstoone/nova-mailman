<?php

namespace Jstoone\Mailman\Mailer;

use Illuminate\Mail\MailServiceProvider;
use Swift_Mailer;

class MailProvider extends MailServiceProvider
{
    public function registerSwiftMailer(): void
    {
        $this->registerMailmanSwiftMailer();
    }

    protected function registerMailmanSwiftMailer(): void
    {
        $this->app->singleton('swift.mailer', function ($app) {
            return new Swift_Mailer(
                $app->make(MailmanTransport::class)
            );
        });
    }
}
