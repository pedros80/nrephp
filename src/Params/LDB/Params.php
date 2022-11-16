<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Params\LDB;

use Pedros80\NREphp\Exceptions\LDB\InvalidParams;
use Pedros80\NREphp\Params\LDB\FilterList;
use Pedros80\NREphp\Params\LDB\FilterType;
use Pedros80\NREphp\Params\LDB\NumRows;
use Pedros80\NREphp\Params\LDB\ServiceID;
use Pedros80\NREphp\Params\LDB\TimeOffset;
use Pedros80\NREphp\Params\LDB\TimeWindow;
use Pedros80\NREphp\Params\StationCode;

final class Params
{
    private function __construct(
        private ?NumRows $numRows = null,
        private ?StationCode $crs = null,
        private ?StationCode $filterCrs = null,
        private ?FilterType $filterType = null,
        private ?TimeOffset $timeOffset = null,
        private ?TimeWindow $timeWindow = null,
        private ?FilterList $filterList = null,
        private ?ServiceID $serviceID = null
    ) {
    }

    public function toArray(): array
    {
        $out = [];

        if ($this->crs) {
            $out['crs'] = (string) $this->crs;
        }

        if ($this->filterCrs) {
            $out['filterCrs'] = (string) $this->filterCrs;
        }

        if ($this->filterType) {
            $out['filterType'] = (string) $this->filterType;
        }

        if ($this->timeOffset) {
            $out['timeOffset'] = $this->timeOffset->value();
        }

        if ($this->timeWindow) {
            $out['timeWindow'] = $this->timeWindow->value();
        }

        if ($this->numRows) {
            $out['numRows'] = $this->numRows->value();
        }

        if ($this->filterList) {
            $out['filterList'] = $this->filterList->value();
        }

        if ($this->serviceID) {
            $out['serviceID'] = (string) $this->serviceID;
        }

        return $out;
    }

    public static function fromArray(array $data): Params
    {
        if (!count($data) || (!isset($data['crs']) && !isset($data['serviceID']))) {
            throw InvalidParams::fromArray($data);
        }

        $numRows    = isset($data['numRows']) ? new NumRows($data['numRows'], $data['numRowsMax']) : null;
        $crs        = isset($data['crs']) ? new StationCode($data['crs']) : null;
        $filterCrs  = isset($data['filterCrs']) ? new StationCode($data['filterCrs']) : null;
        $filterType = isset($data['filterType']) ? new FilterType($data['filterType']) : null;
        $timeOffset = isset($data['timeOffset']) ? new TimeOffset($data['timeOffset']) : null;
        $timeWindow = isset($data['timeWindow']) ? new TimeWindow($data['timeWindow']) : null;
        $filterList = isset($data['filterList']) ? new FilterList($data['filterList'], $data['filterListLength']) : null;
        $serviceId  = isset($data['serviceID']) ? new ServiceID($data['serviceID']) : null;

        return new Params($numRows, $crs, $filterCrs, $filterType, $timeOffset, $timeWindow, $filterList, $serviceId);
    }
}
