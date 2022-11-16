<?php

declare(strict_types=1);

namespace Tests\Unit\Params\HSP;

use Pedros80\NREphp\Exceptions\HSP\InvalidParams;
use Pedros80\NREphp\Params\HSP\Params;
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
        $this->expectExceptionMessage('Invalid params: must contain either metrics or details params.');

        Params::fromArray([
            'tolerance' => [1,2,3],
        ]);
    }

    public function testRIDParamsCanBeInstantiated(): void
    {
        $params = Params::fromArray([
            'rid' => '201607013361763',
        ]);

        $this->assertEquals(['rid' => '201607013361763'], $params->toArray());
    }

    public function testMetricsStyleParamsCanBeInstantiated(): void
    {
        $params = Params::fromArray([
            'from_loc'       => 'DAM',
            'to_loc'         => 'KDY',
            'from_date_time' => '2020-01-01 07:00:00',
            'to_date_time'   => '2020-01-02 08:00:00',
            'days'           => 'WEEKDAY',
            'tolerance'      => [1, 2, 3],
            'toc'            => 'ZZ',
        ]);

        $this->assertEquals([
            'from_loc'  => 'DAM',
            'to_loc'    => 'KDY',
            'from_time' => '0700',
            'from_date' => '2020-01-01',
            'to_time'   => '0800',
            'to_date'   => '2020-01-02',
            'days'      => 'WEEKDAY',
            'tolerance' => [1, 2, 3],
            'toc'       => 'ZZ',
        ], $params->toArray());
    }

    public function testDetailsStyleParamsCanBeInstantiated(): void
    {
        $params = Params::fromArray([
            'rid' => '201607013361763',
        ]);

        $this->assertEquals([
            'rid' => '201607013361763',
        ], $params->toArray());
    }
}
