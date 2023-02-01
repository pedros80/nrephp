<?php

declare(strict_types=1);

namespace Tests\Unit\Params;

use Pedros80\NREphp\Exceptions\InvalidStationCode;
use Pedros80\NREphp\Params\StationCode;
use PHPUnit\Framework\TestCase;

final class StationCodeTest extends TestCase
{
    public function testValidStationCanBeInstantiated(): void
    {
        $dalmeny = new StationCode('DAM');

        $this->assertInstanceOf(StationCode::class, $dalmeny);
        $this->assertEquals('Dalmeny', $dalmeny->name());
        $this->assertEquals('DAM', (string) $dalmeny);
    }

    public function testUnknownStationCanBeInstantiated(): void
    {
        $unknown = new StationCode('???');

        $this->assertInstanceOf(StationCode::class, $unknown);
        $this->assertEquals('Unknown', $unknown->name());
        $this->assertEquals('???', (string) $unknown);
    }

    public function testInvalidStationCodeThrowsException(): void
    {
        $this->expectException(InvalidStationCode::class);
        $this->expectExceptionMessage('XXX is not a valid Station Code.');

        new StationCode('XXX');
    }

    public function testRandomStationCode(): void
    {
        $station = StationCode::random();

        $this->assertInstanceOf(StationCode::class, $station);
    }

    public function testListReturnsArray(): void
    {
        $stations = StationCode::list();

        $this->assertIsArray($stations);
    }
}
