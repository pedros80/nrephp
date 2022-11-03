<?php

namespace Tests\Darwin;

use Pedros80\NREphp\Darwin\Exceptions\InvalidStationCode;
use Pedros80\NREphp\Darwin\StationCode;
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
}
