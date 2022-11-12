<?php

namespace Tests\OpenData\DTD;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Pedros80\NREphp\OpenData\DTD\DTD;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

final class DTDTest extends TestCase
{
    use ProphecyTrait;

    public function testDTDCanBeInstantiated(): void
    {
        $client = $this->prophesize(Client::class);
        $dtd    = new DTD($client->reveal());

        $this->assertInstanceOf(DTD::class, $dtd);
    }

    public function testFaresReturnsAString(): void
    {
        $client = $this->prophesize(Client::class);
        $dtd    = new DTD($client->reveal());

        $client->get('2.0/fares', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(new Response(200, [], 'some text that is really a zip file...'));

        $result = $dtd->fares('token');

        $this->assertIsString($result);
    }

    public function testRouteingReturnsAString(): void
    {
        $client = $this->prophesize(Client::class);
        $dtd    = new DTD($client->reveal());

        $client->get('2.0/routeing', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(new Response(200, [], 'some text that is really a zip file...'));

        $result = $dtd->routeing('token');

        $this->assertIsString($result);
    }

    public function testTimetableReturnsAString(): void
    {
        $client = $this->prophesize(Client::class);
        $dtd    = new DTD($client->reveal());

        $client->get('3.0/timetable', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(new Response(200, [], 'some text that is really a zip file...'));

        $result = $dtd->timetable('token');

        $this->assertIsString($result);
    }
}
