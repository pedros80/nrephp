<?php

declare(strict_types=1);

namespace Tests\Unit\Params\HistoricalServicePerformance;

use Pedros80\NREphp\Exceptions\InvalidDays;
use Pedros80\NREphp\Params\HistoricalServicePerformance\Days;
use PHPUnit\Framework\TestCase;

final class DaysTest extends TestCase
{

    public function testValidDaysCanBeInstantiated(): void
    {
        $days = new Days('WEEKDAY');

        $this->assertInstanceOf(Days::class, $days);
        $this->assertEquals('WEEKDAY', (string) $days);
    }

    public function testValidWrongCaseDaysCanBeInstantiated(): void
    {
        $days = new Days('saturday');

        $this->assertInstanceOf(Days::class, $days);
        $this->assertEquals('SATURDAY', (string) $days);
    }

    public function testInvalidDaysThrowsException(): void
    {
        $this->expectException(InvalidDays::class);
        $this->expectExceptionMessage('Invalid days: St Swithins Day; must be one of WEEKDAY, SATURDAY, SUNDAY');

        new Days('St Swithins Day');
    }
}
