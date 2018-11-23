<?php

namespace Jstoone\Mailman\Mailer;

use Jstoone\Mailman\GenerateMailIdentifier;

class MailIdentifier
{
    public static function generate(): string
    {
        return app(GenerateMailIdentifier::class)->__invoke();
    }
}
