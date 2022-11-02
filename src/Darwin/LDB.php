<?php

namespace Pedros80\NREphp\Darwin;

use Pedros80\NREphp\Darwin\Exceptions\LDBException;
use Pedros80\NREphp\Darwin\FilterList;
use Pedros80\NREphp\Darwin\NumRows;
use Pedros80\NREphp\Darwin\Params;
use Pedros80\NREphp\Darwin\ServiceID;
use SoapClient;
use SoapFault;
use stdClass;

final class LDB
{
    public function __construct(
        private SoapClient $client,
    ) {
    }

    public function getArrBoardWithDetails(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return $this->stationBoardWithDetails('GetArrBoardWithDetails', $numRows, $crs, $filterCrs, $filterType, $timeOffset, $timeWindow);
    }

    public function getArrDepBoardWithDetails(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return $this->stationBoardWithDetails('GetArrDepBoardWithDetails', $numRows, $crs, $filterCrs, $filterType, $timeOffset, $timeWindow);
    }

    public function getArrivalBoard(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return $this->stationBoard('GetArrivalBoard', $numRows, $crs, $filterCrs, $filterType, $timeOffset, $timeWindow);
    }

    public function getArrivalDepartureBoard(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return $this->stationBoard('GetArrivalDepartureBoard', $numRows, $crs, $filterCrs, $filterType, $timeOffset, $timeWindow);
    }

    public function getDepartureBoard(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return $this->stationBoard('GetDepartureBoard', $numRows, $crs, $filterCrs, $filterType, $timeOffset, $timeWindow);
    }

    public function getDepBoardWithDetails(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return $this->stationBoardWithDetails('GetDepBoardWithDetails', $numRows, $crs, $filterCrs, $filterType, $timeOffset, $timeWindow);
    }

    public function getFastestDepartures(
        string $crs,
        array $filterList,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return $this->departuresBoard('GetFastestDepartures', $crs, $filterList, FilterList::MED, $timeOffset, $timeWindow);
    }

    public function getFastestDeparturesWithDetails(
        string $crs,
        array $filterList,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return $this->departuresBoard('GetFastestDeparturesWithDetails', $crs, $filterList, FilterList::SHORT, $timeOffset, $timeWindow);
    }

    public function getNextDepartures(
        string $crs,
        array $filterList,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return $this->departuresBoard('GetNextDepartures', $crs, $filterList, FilterList::LONG, $timeOffset, $timeWindow);
    }

    public function getNextDeparturesWithDetails(
        string $crs,
        array $filterList,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return $this->departuresBoard('GetNextDeparturesWithDetails', $crs, $filterList, FilterList::SHORT, $timeOffset, $timeWindow);
    }

    public function getServiceDetails(ServiceID $serviceID): stdClass
    {
        $params = Params::fromArray(['serviceID' => (string) $serviceID]);

        return $this->call('GetServiceDetails', $params);
    }

    private function departuresBoard(
        string $method,
        string $crs,
        array $filterList,
        int $filterListLength,
        ?int $timeOffset,
        ?int $timeWindow,
    ): stdClass {
        $params = [
            'crs'              => $crs,
            'filterList'       => $filterList,
            'filterListLength' => $filterListLength,
            'timeOffset'       => $timeOffset,
            'timeWindow'       => $timeWindow,
        ];

        return $this->call($method, Params::fromArray($params));
    }

    private function stationBoardWithDetails(
        string $method,
        int $numRows,
        string $crs,
        ?string $filterCrs,
        ?string $filterType,
        ?int $timeOffset,
        ?int $timeWindow,
    ): stdClass {
        return $this->stationBoard($method, $numRows, $crs, $filterCrs, $filterType, $timeOffset, $timeWindow, NumRows::SHORT);
    }

    private function stationBoard(
        string $method,
        int $numRows,
        string $crs,
        ?string $filterCrs,
        ?string $filterType,
        ?int $timeOffset,
        ?int $timeWindow,
        int $numRowsMax = NumRows::LONG
    ): stdClass {
        $params = [
            'numRows'    => $numRows,
            'numRowsMax' => $numRowsMax,
            'crs'        => $crs,
            'filterCrs'  => $filterCrs,
            'filterType' => $filterType,
            'timeOffset' => $timeOffset,
            'timeWindow' => $timeWindow,
        ];

        return $this->call($method, Params::fromArray($params));
    }

    private function call(string $method, Params $params): stdClass
    {
        try {
            return $this->client->$method($params->toArray());
        } catch (SoapFault $e) {
            throw LDBException::fromResponse(
                $e->getMessage(),
                $this->client->__getLastRequest(),
                $this->client->__getLastResponse()
            );
        }
    }
}
