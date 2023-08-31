<?php

namespace Pedros80\NREphp\Contracts;

use stdClass;

interface Boards
{
    public function getArrBoardWithDetails(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass;

    public function getArrDepBoardWithDetails(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass;

    public function getArrivalBoard(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass;

    public function getArrivalDepartureBoard(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass;

    public function getDepartureBoard(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass;

    public function getDepBoardWithDetails(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass;

    public function getFastestDepartures(
        string $crs,
        array $filterList,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass;

    public function getFastestDeparturesWithDetails(
        string $crs,
        array $filterList,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass;

    public function getNextDepartures(
        string $crs,
        array $filterList,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass;

    public function getNextDeparturesWithDetails(
        string $crs,
        array $filterList,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass;

    public function getServiceDetails(string $serviceID): stdClass;
}
