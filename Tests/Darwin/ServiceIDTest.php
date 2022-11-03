<?php

namespace Tests\Darwin;

use Pedros80\NREphp\Darwin\ServiceID;
use PHPUnit\Framework\TestCase;

final class ServiceIDTest extends TestCase
{
    public function testServiceIDCanBeInstantiated(): void
    {
        $serviceID = new ServiceID('XgYARy78i+wCxNwYRBBEUg==');

        $this->assertInstanceOf(ServiceID::class, $serviceID);
        $this->assertEquals('XgYARy78i+wCxNwYRBBEUg==', (string) $serviceID);
    }
}
