<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Pedros80\NREphp\Exceptions\LiveDepartureBoard\LiveDepartureBoardException;
use Pedros80\NREphp\Services\LiveDepartureBoard;
use PHPUnit\Framework\TestCase;
use SoapFault;
use Tests\MockSoapClient;

final class LiveDepartureBoardTest extends TestCase
{
    private LiveDepartureBoard $ldb;

    public function setUp(): void
    {
        parent::setUp();

        $responses = static function ($method, $arguments) {
            switch ($method) {
                case 'GetDepartureBoard':
                case 'GetArrivalBoard':
                case 'GetArrivalDepartureBoard':
                    return json_decode('{"GetStationBoardResult":{"generatedAt":"2022-11-04T16:15:30.5820839+00:00","locationName":"Dalmeny","crs":"DAM","platformAvailable":true,"trainServices":{"service":[{"std":"16:24","etd":"16:26","platform":"1","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"H1iFod5UoxwclMvg4ntVuA==","origin":{"location":[{"locationName":"Cowdenbeath","crs":"COW"}]},"destination":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]}}]}}}');
                case 'GetArrBoardWithDetails':
                case 'GetArrDepBoardWithDetails':
                case 'GetDepBoardWithDetails':
                    return json_decode('{"GetStationBoardResult":{"generatedAt":"2022-11-04T16:21:43.3925018+00:00","locationName":"Dalmeny","crs":"DAM","platformAvailable":true,"trainServices":{"service":[{"sta":"16:24","eta":"On time","platform":"1","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"H1iFod5UoxwclMvg4ntVuA==","origin":{"location":[{"locationName":"Cowdenbeath","crs":"COW"}]},"destination":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"previousCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"Cowdenbeath","crs":"COW","st":"16:00","at":"On time"},{"locationName":"Dunfermline Queen Margaret","crs":"DFL","st":"16:05","at":"On time"},{"locationName":"Dunfermline Town","crs":"DFE","st":"16:09","at":"On time"},{"locationName":"Rosyth","crs":"ROS","st":"16:12","at":"16:14"},{"locationName":"Inverkeithing","crs":"INK","st":"16:16","at":"16:18"},{"locationName":"North Queensferry","crs":"NQU","st":"16:21","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}}]}}}');
                case 'GetFastestDepartures':
                    return json_decode('{"DeparturesBoard":{"generatedAt":"2022-11-05T09:05:04.7956433+00:00","locationName":"Dalmeny","crs":"DAM","platformAvailable":true,"departures":{"destination":[{"service":{"sta":"09:17","eta":"On time","std":"09:17","etd":"On time","platform":"2","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"mzCXFZ9LoeqyY0veTB6FfA==","rsid":"SR454400","origin":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"destination":{"location":[{"locationName":"Cowdenbeath","crs":"COW"}]}},"crs":"INK"},{"service":null,"crs":"DEE"}]}}}');
                case 'GetFastestDeparturesWithDetails':
                    return json_decode('{"DeparturesBoard":{"generatedAt":"2022-11-05T09:07:31.91167+00:00","locationName":"Dalmeny","crs":"DAM","platformAvailable":true,"departures":{"destination":[{"service":{"sta":"09:17","eta":"On time","std":"09:17","etd":"On time","platform":"2","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"mzCXFZ9LoeqyY0veTB6FfA==","rsid":"SR454400","origin":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"destination":{"location":[{"locationName":"Cowdenbeath","crs":"COW"}]},"subsequentCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"North Queensferry","crs":"NQU","st":"09:20","et":"On time"},{"locationName":"Inverkeithing","crs":"INK","st":"09:24","et":"On time"},{"locationName":"Rosyth","crs":"ROS","st":"09:28","et":"On time"},{"locationName":"Dunfermline Town","crs":"DFE","st":"09:33","et":"On time"},{"locationName":"Dunfermline Queen Margaret","crs":"DFL","st":"09:37","et":"On time"},{"locationName":"Cowdenbeath","crs":"COW","st":"09:43","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},"crs":"INK"},{"service":null,"crs":"DEE"}]}}}');
                case 'GetNextDepartures':
                    return json_decode('{"DeparturesBoard":{"generatedAt":"2022-11-05T09:14:12.2028543+00:00","locationName":"Dalmeny","crs":"DAM","platformAvailable":true,"departures":{"destination":[{"service":{"sta":"09:17","eta":"On time","std":"09:17","etd":"On time","platform":"2","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"mzCXFZ9LoeqyY0veTB6FfA==","rsid":"SR454400","origin":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"destination":{"location":[{"locationName":"Cowdenbeath","crs":"COW"}]}},"crs":"INK"},{"service":null,"crs":"DEE"}]}}}');
                case 'GetNextDeparturesWithDetails':
                    return json_decode('{"DeparturesBoard":{"generatedAt":"2022-11-05T09:15:14.4194972+00:00","locationName":"Dalmeny","crs":"DAM","platformAvailable":true,"departures":{"destination":[{"service":{"sta":"09:17","eta":"On time","std":"09:17","etd":"On time","platform":"2","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"mzCXFZ9LoeqyY0veTB6FfA==","rsid":"SR454400","origin":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"destination":{"location":[{"locationName":"Cowdenbeath","crs":"COW"}]},"subsequentCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"North Queensferry","crs":"NQU","st":"09:20","et":"On time"},{"locationName":"Inverkeithing","crs":"INK","st":"09:24","et":"On time"},{"locationName":"Rosyth","crs":"ROS","st":"09:28","et":"On time"},{"locationName":"Dunfermline Town","crs":"DFE","st":"09:33","et":"On time"},{"locationName":"Dunfermline Queen Margaret","crs":"DFL","st":"09:37","et":"On time"},{"locationName":"Cowdenbeath","crs":"COW","st":"09:43","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},"crs":"INK"},{"service":null,"crs":"DEE"}]}}}');
                case 'GetServiceDetails':
                    if ($arguments[0]['serviceID'] === 'INVALID') {
                        throw new SoapFault('Server', 'Invalid Service ID', $method);
                    }
                    return json_decode('{"GetServiceDetailsResult":{"generatedAt":"2022-11-05T09:17:25.6875364+00:00","serviceType":"train","locationName":"Dalmeny","crs":"DAM","operator":"ScotRail","operatorCode":"SR","rsid":"SR454400","platform":"2","sta":"09:17","ata":"On time","std":"09:17","etd":"On time","previousCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"Edinburgh","crs":"EDB","st":"09:00","at":"On time"},{"locationName":"Haymarket","crs":"HYM","st":"09:04","at":"On time"},{"locationName":"South Gyle","crs":"SGL","st":"09:09","at":"On time"},{"locationName":"Edinburgh Gateway","crs":"EGY","st":"09:11","at":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]},"subsequentCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"North Queensferry","crs":"NQU","st":"09:20","et":"On time"},{"locationName":"Inverkeithing","crs":"INK","st":"09:24","et":"On time"},{"locationName":"Rosyth","crs":"ROS","st":"09:28","et":"On time"},{"locationName":"Dunfermline Town","crs":"DFE","st":"09:33","et":"On time"},{"locationName":"Dunfermline Queen Margaret","crs":"DFL","st":"09:37","et":"On time"},{"locationName":"Cowdenbeath","crs":"COW","st":"09:43","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}}}');
            }

            throw new SoapFault('Server', sprintf('Unknown SOAP method "%s"', $method));
        };
        $client = new MockSoapClient($responses);

        $this->ldb = new LiveDepartureBoard($client);
    }

    public function testGetDepartureBoardReturnsObject(): void
    {
        $this->assertIsObject($this->ldb->getDepartureBoard(1, 'DAM'));
    }

    public function testGetArrivalBoardReturnsObject(): void
    {
        $this->assertIsObject($this->ldb->getArrivalBoard(1, 'DAM'));
    }

    public function testGetArrivalDepartureBoardReturnsObject(): void
    {
        $this->assertIsObject($this->ldb->getArrivalDepartureBoard(1, 'DAM'));
    }

    public function testGetArrBoardWithDetailsReturnsObject(): void
    {
        $this->assertIsObject($this->ldb->getArrBoardWithDetails(1, 'DAM'));
    }

    public function testGetArrDepBoardWithDetailsReturnsObject(): void
    {
        $this->assertIsObject($this->ldb->getArrDepBoardWithDetails(1, 'DAM'));
    }

    public function testGetDepBoardWithDetailsReturnsObject(): void
    {
        $this->assertIsObject($this->ldb->getDepBoardWithDetails(1, 'DAM'));
    }

    public function testGetFastestDeparturesReturnsObject(): void
    {
        $this->assertIsObject($this->ldb->getFastestDepartures('DAM', ['INK', 'DEE']));
    }

    public function testGetFastestDeparturesWithDetailsReturnsObject(): void
    {
        $this->assertIsObject($this->ldb->getFastestDeparturesWithDetails('DAM', ['INK', 'DEE']));
    }

    public function testGetNextDeparturesReturnsObject(): void
    {
        $this->assertIsObject($this->ldb->getNextDepartures('DAM', ['INK', 'DEE']));
    }

    public function testGetNextDeparturesWithDetailsReturnsObject(): void
    {
        $this->assertIsObject($this->ldb->getNextDeparturesWithDetails('DAM', ['INK', 'DEE']));
    }

    public function testGetServiceDetailsReturnsObject(): void
    {
        $this->assertIsObject($this->ldb->getServiceDetails('mzCXFZ9LoeqyY0veTB6FfA=='));
    }

    public function testLiveDepartureBoardCanThrowException(): void
    {
        $this->expectException(LiveDepartureBoardException::class);
        $this->assertIsObject($this->ldb->getServiceDetails('INVALID'));
    }
}
