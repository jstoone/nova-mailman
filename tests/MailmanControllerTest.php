<?php

namespace Jstoone\Mailman\Tests;

class ToolControllerTest extends TestCase
{
    /** @test */
    public function it_can_can_return_a_response()
    {
        $this
            ->get('nova-vendor/jstoone/nova-mailman/endpoint')
            ->assertSuccessful();
    }
}
