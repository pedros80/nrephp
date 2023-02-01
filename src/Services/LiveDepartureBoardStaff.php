<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Services;

use Pedros80\NREphp\Exceptions\LiveDepartureBoard\LiveDepartureBoardException;
use Pedros80\NREphp\Params\LiveDepartureBoard\NumRows;
use Pedros80\NREphp\Params\LiveDepartureBoard\Params;
use SoapClient;
use SoapFault;
use stdClass;

final class LiveDepartureBoardStaff
{
    public function __construct(
        private SoapClient $client,
    ) {
    }

    /**
     *
     * GetArrivalBoardByCRS
     * GetArrivalBoardByTIPLOC
     * GetArrivalDepartureBoardByCRS
     * GetArrivalDepartureBoardByTIPLOC
     * GetDepartureBoardByCRS
     * GetDepartureBoardByTIPLOC
     * GetDisruptionList
     * GetFastestDepartures
     * GetFastestDeparturesWithDetails
     * GetHistoricDepartureBoard
     * GetHistoricServiceDetails
     * GetHistoricTimeLine
     * GetNextDepartures
     * GetNextDeparturesWithDetails
     * GetReasonCode [Deprecated]
     * GetReasonCodeList [Deprecated]
     * GetServiceDetailsByRID
     * GetSourceInstanceNames [Deprecated]
     * QueryHistoricServices
     * QueryServices
     */

    public function getArrBoardWithDetails(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null,
        ?string $filterToc = null,
        ?string $services = 'P',
        bool $getNonPassengerServices = false
    ): stdClass {
        return $this->stationBoardWithDetails(
            'GetArrBoardWithDetails',
            $numRows,
            $crs,
            $filterCrs,
            $filterType,
            $timeOffset,
            $timeWindow,
            $filterToc,
            $services,
            $getNonPassengerServices
        );
    }

    public function getArrDepBoardWithDetails(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null,
        ?string $filterToc = null,
        ?string $services = 'P',
        bool $getNonPassengerServices = false
    ): stdClass {
        return $this->stationBoardWithDetails(
            'GetArrDepBoardWithDetails',
            $numRows,
            $crs,
            $filterCrs,
            $filterType,
            $timeOffset,
            $timeWindow,
            $filterToc,
            $services,
            $getNonPassengerServices
        );
    }

    public function getDepBoardWithDetails(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null,
        ?string $filterToc = null,
        ?string $services = 'P',
        bool $getNonPassengerServices = false
    ): stdClass {
        return $this->stationBoardWithDetails(
            'GetDepBoardWithDetails',
            $numRows,
            $crs,
            $filterCrs,
            $filterType,
            $timeOffset,
            $timeWindow,
            $filterToc,
            $services,
            $getNonPassengerServices
        );
    }

    private function stationBoard(
        string $method,
        int $numRows,
        string $crs,
        ?string $filterCrs,
        ?string $filterType,
        ?int $timeOffset,
        ?int $timeWindow,
        ?string $filterToc,
        ?string $services,
        bool $getNonPassengerServices,
        int $numRowsMax = NumRows::LONG
    ): stdClass {
        $params = [
            'numRows'                 => $numRows,
            'numRowsMax'              => $numRowsMax,
            'crs'                     => $crs,
            'filterCrs'               => $filterCrs,
            'filterType'              => $filterType,
            'timeOffset'              => $timeOffset,
            'timeWindow'              => $timeWindow,
            'filterToc'               => $filterToc,
            'services'                => $services,
            'getNonPassengerServices' => $getNonPassengerServices,
            'time'                    => date('H:i:s'),
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
        ?string $filterToc,
        ?string $services,
        bool $getNonPassengerServices,
    ): stdClass {
        return $this->stationBoard(
            $method,
            $numRows,
            $crs,
            $filterCrs,
            $filterType,
            $timeOffset,
            $timeWindow,
            $filterToc,
            $services,
            $getNonPassengerServices,
            NumRows::SHORT
        );
    }

    private function call(string $method, Params $params): stdClass
    {
        try {
            return $this->client->$method($params->toArray());
        } catch (SoapFault $e) {
            throw LiveDepartureBoardException::fromResponse(
                $e->getMessage(),
                $this->client->__getLastRequest(),
                $this->client->__getLastResponse()
            );
        }
    }
}
