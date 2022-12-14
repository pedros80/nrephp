<?php

declare(strict_types=1);

namespace Tests\Unit\Params\LiveDepartureBoard;

use Pedros80\NREphp\Params\LiveDepartureBoard\ServiceID;
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
