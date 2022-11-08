<?php

namespace Tests\Darwin\Params\HSP;

use Pedros80\NREphp\Darwin\Exceptions\HSP\InvalidDays;
use Pedros80\NREphp\Darwin\Params\HSP\Days;
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
