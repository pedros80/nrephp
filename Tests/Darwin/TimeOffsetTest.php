<?php

declare(strict_types=1);

namespace Tests\Darwin;

use Pedros80\NREphp\Darwin\Exceptions\InvalidTimeOffset;
use Pedros80\NREphp\Darwin\TimeOffset;
use PHPUnit\Framework\TestCase;

final class TimeOffsetTest extends TestCase
{
    public function testOffsetInstantiates(): void
    {
        $values = [0, -120, 120, 99, -99];

        foreach ($values as $value) {
            $timeOffset = new TimeOffset($value);
            $this->assertInstanceOf(TimeOffset::class, $timeOffset);
            $this->assertEquals($value, $timeOffset->value());
        }
    }

    public function testOffsetLessThanMinThrowsException(): void
    {
        $value = TimeOffset::MIN - 1;
        $this->expectException(InvalidTimeOffset::class);
        $this->expectExceptionMessage('Invalid time offset: -121; must be between -120 and 120');

        new TimeOffset($value);
    }

    public function testOffsetGreaterThanMaxThrowsException(): void
    {
        $value = TimeOffset::MAX + 1;
        $this->expectException(InvalidTimeOffset::class);
        $this->expectExceptionMessage('Invalid time offset: 121; must be between -120 and 120');

        new TimeOffset($value);
    }
}
