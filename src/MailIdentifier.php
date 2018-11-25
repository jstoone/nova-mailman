<?php

namespace Jstoone\Mailman;

class MailIdentifier
{
    public static function generate(): string
    {
        return app(GenerateMailIdentifier::class)->__invoke();
    }
}
