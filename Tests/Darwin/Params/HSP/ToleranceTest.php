<?php

namespace Tests\Darwin\Params\HSP;

use Pedros80\NREphp\Darwin\Exceptions\HSP\InvalidTolerance;
use Pedros80\NREphp\Darwin\Params\HSP\Tolerance;
use PHPUnit\Framework\TestCase;

final class ToleranceTest extends TestCase
{
    public function testValidToleranceCanBeInstantiated(): void
    {
        $tolerance = new Tolerance([1, 3, 5]);

        $this->assertInstanceOf(Tolerance::class, $tolerance);
        $this->assertEquals([1, 3, 5], $tolerance->values());
    }

    public function testToleranceTooLongThrowsException(): void
    {
        $this->expectException(InvalidTolerance::class);
        $this->expectExceptionMessage('Invalid tolerance list length: 10; must be between 0 and 3');

        new Tolerance([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
    }

    public function testToleranceNonIntegerThrowsException(): void
    {
        $this->expectException(InvalidTolerance::class);
        $this->expectExceptionMessage('Invalid tolerance list: one is not an integer');

        new Tolerance(['one', '2', '3']);
    }
}
