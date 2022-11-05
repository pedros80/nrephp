<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin;

use Pedros80\NREphp\Darwin\FilterList;
use Pedros80\NREphp\Darwin\FilterType;
use Pedros80\NREphp\Darwin\NumRows;
use Pedros80\NREphp\Darwin\ServiceID;
use Pedros80\NREphp\Darwin\StationCode;
use Pedros80\NREphp\Darwin\TimeOffset;
use Pedros80\NREphp\Darwin\TimeWindow;

final class Params
{
    public function __construct(
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
