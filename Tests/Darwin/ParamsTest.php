<?php

namespace Tests\Darwin;

use Pedros80\NREphp\Darwin\Params;
use PHPUnit\Framework\TestCase;

final class ParamsTest extends TestCase
{
    public function testEmptyParamsCanBeInstantiated(): void
    {
        $params = Params::fromArray([]);
        $this->assertInstanceOf(Params::class, $params);
        $this->assertEquals([], $params->toArray());
    }

    public function testServiceIDParamsCanBeInstantiated(): void
    {
        $params = Params::fromArray([
            'serviceID' => 'XgYARy78i+wCxNwYRBBEUg==',
        ]);

        $this->assertEquals(['serviceID' => 'XgYARy78i+wCxNwYRBBEUg=='], $params->toArray());
    }

    public function testBoardStyleParamsCanBeInstantiated(): void
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
