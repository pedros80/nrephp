<?php

declare(strict_types=1);

namespace Tests\Unit\Params\LiveDepartureBoard;

use Pedros80\NREphp\Exceptions\LiveDepartureBoard\InvalidParams;
use Pedros80\NREphp\Params\LiveDepartureBoard\Params;
use PHPUnit\Framework\TestCase;

final class ParamsTest extends TestCase
{
    public function testEmptyParamsCantBeInstantiated(): void
    {
        $this->expectException(InvalidParams::class);
        $this->expectExceptionMessage('Invalid params: can not be empty.');

        Params::fromArray([]);
    }

    public function testInvalidParamsCantBeInstantiated(): void
    {
        $this->expectException(InvalidParams::class);
        $this->expectExceptionMessage('Invalid params: must contain either board or service params.');

        Params::fromArray([
            'numRows'    => 10,
            'numRowsMax' => 10
        ]);
    }

    public function testServiceIDParamsCanBeInstantiated(): void
    {
        $params = Params::fromArray([
            'serviceID' => 'XgYARy78i+wCxNwYRBBEUg==',
        ]);

        $this->assertEquals(['serviceID' => 'XgYARy78i+wCxNwYRBBEUg=='], $params->toArray());
    }

    public function testStationBoardStyleParamsCanBeInstantiated(): void
    {
        $params = Params::fromArray([
            'numRows'    => 10,
            'numRowsMax' => 10,
            'crs'        => 'DAM',
            'filterCrs'  => 'KDY',
            'filterType' => 'from',
            'timeOffset' => 12,
            'timeWindow' => -12,
        ]);

        $this->assertEquals([
            'crs'        => 'DAM',
            'filterCrs'  => 'KDY',
            'filterType' => 'from',
            'timeOffset' => 12,
            'timeWindow' => -12,
            'numRows'    => 10,
        ], $params->toArray());
    }

    public function testDeparturesBoardStyleParamsCanBeInstantiated(): void
    {
        $params = Params::fromArray([
            'crs'              => 'DAM',
            'filterList'       => ['KDY', 'DEE'],
            'filterListLength' => 15,
            'timeOffset'       => 12,
            'timeWindow'       => -12,
        ]);

        $this->assertEquals([
            'crs'              => 'DAM',
            'filterList'       => ['KDY', 'DEE'],
            'timeOffset'       => 12,
            'timeWindow'       => -12,
        ], $params->toArray());
    }
}
