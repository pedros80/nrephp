<?php

declare(strict_types=1);

namespace Tests\Darwin\Params;

use Pedros80\NREphp\Darwin\Exceptions\InvalidTimeWindow;
use Pedros80\NREphp\Darwin\Params\TimeWindow;
use PHPUnit\Framework\TestCase;

final class TimeWindowTest extends TestCase
{
    public function testWindowInstantiates(): void
    {
        $values = [0, -120, 120, 99, -99];

        foreach ($values as $value) {
            $timeWindow = new TimeWindow($value);
            $this->assertInstanceOf(TimeWindow::class, $timeWindow);
            $this->assertEquals($value, $timeWindow->value());
        }
    }

    public function testWindowLessThanMinThrowsException(): void
    {
        $value = TimeWindow::MIN - 1;
        $this->expectException(InvalidTimeWindow::class);
        $this->expectExceptionMessage('Invalid time window: -121; must be between -120 and 120');

        new TimeWindow($value);
    }

    public function testWindowGreaterThanMaxThrowsException(): void
    {
        $value = TimeWindow::MAX + 1;
        $this->expectException(InvalidTimeWindow::class);
        $this->expectExceptionMessage('Invalid time window: 121; must be between -120 and 120');

        new TimeWindow($value);
    }
}
