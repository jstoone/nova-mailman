<?php

namespace Jstoone\Mailman;

use Illuminate\Support\Str;

class GenerateMailIdentifier
{
    public function __invoke()
    {
        return Str::uuid();
    }
}
