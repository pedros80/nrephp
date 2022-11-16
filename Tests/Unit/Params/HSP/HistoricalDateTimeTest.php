<?php

declare(strict_types=1);

namespace Tests\Unit\Params\HSP;

use Pedros80\NREphp\Exceptions\InvalidHistoricalDateTime;
use Pedros80\NREphp\Params\HSP\HistoricalDateTime;
use PHPUnit\Framework\TestCase;

final class HistoricalDateTimeTest extends TestCase
{
    /**
     * @dataProvider provideValid
     */
    public function testValidTimesCanBeInstantiated(string $date, string $time, string $expectedTime): void
    {
        $dateTime = HistoricalDateTime::fromString("{$date} {$time}");

        $this->assertInstanceOf(HistoricalDateTime::class, $dateTime);
        $this->assertEquals($expectedTime, $dateTime->time());
        $this->assertEquals($date, $dateTime->date());
    }

    /**
     * @dataProvider provideInvalidTimes
     */
    public function testInvalidTimesThrowException(string $date, string $time): void
    {
        $this->expectException(InvalidHistoricalDateTime::class);
        $this->expectExceptionMessage("Invalid date time: {$date} {$time}");

        HistoricalDateTime::fromString("{$date} {$time}");
    }

    public function provideValid(): array
    {
        return [
            ['2000-01-01', '09:00:00', '0900'],
            ['2000-01-01', '23:59:00', '2359'],
            ['2000-01-01', '00:00:00', '0000'],
        ];
    }

    public function provideInvalidTimes(): array
    {
        return [
            ['yesterday', 'nine of the clock'],
            [date('Y-m-d', strtotime('+1 week')), '09:00:00'],
        ];
    }
}
