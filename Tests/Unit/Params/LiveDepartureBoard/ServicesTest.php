<?php

declare(strict_types=1);

namespace Tests\Unit\Params\LiveDepartureBoard;

use Pedros80\NREphp\Exceptions\InvalidServices;
use Pedros80\NREphp\Params\LiveDepartureBoard\Services;
use PHPUnit\Framework\TestCase;

final class ServicesTest extends TestCase
{
    public function testValidServicesCanBeInstantiated(): void
    {
        $services = new Services('P');

        $this->assertInstanceOf(Services::class, $services);
        $this->assertEquals('P', (string) $services);
    }

    public function testInvalidServicesThrowsException(): void
    {
        $this->expectException(InvalidServices::class);
        $this->expectExceptionMessage('X is not a valid Services choice.');

        new Services('X');
    }
}
