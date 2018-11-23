<?php

namespace Jstoone\Mailman\Tests;

use Jstoone\Mailman\GenerateMailIdentifier;
use Ramsey\Uuid\Uuid;

class GenerateMailIdentiferTest extends TestCase
{
    /** @test */
    public function it_generates_a_valid_uuid()
    {
        $identifier = app(GenerateMailIdentifier::class)->__invoke();

        $this->assertTrue(Uuid::isValid($identifier));
    }
}
