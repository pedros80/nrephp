<?php

namespace Pedros80\NREphp\Darwin;

use Pedros80\NREphp\Darwin\Exceptions\InvalidFilterList;
use Pedros80\NREphp\Darwin\StationCode;

final class FilterList
{
    public const SHORT = 10;
    public const MED   = 15;
    public const LONG  = 25;

    private array $stations;

    public function __construct(
        array $stations,
        int $max
    ) {
        if (count($stations) < 1 || count($stations) > $max) {
            throw InvalidFilterList::fromNumber(count($stations), $max);
        }

        $this->stations = array_map(fn (string $station) => new StationCode($station), $stations);
    }

    public function value(): array
    {
        return array_map(fn (StationCode $station) => (string) $station, $this->stations);
    }
}
