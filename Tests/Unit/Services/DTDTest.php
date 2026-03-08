<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Pedros80\NREphp\Services\DTD;
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

    public function testFaresCallsClient(): void
    {
        $client = $this->prophesize(Client::class);
        $dtd    = new DTD($client->reveal());

        $client->get('2.0/fares', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(new Response(200, [], 'some text that is really a zip file...'))->shouldBeCalled();

        $dtd->fares('token');
    }

    public function testRouteingCallsClient(): void
    {
        $client = $this->prophesize(Client::class);
        $dtd    = new DTD($client->reveal());

        $client->get('2.0/routeing', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(new Response(200, [], 'some text that is really a zip file...'))->shouldBeCalled();

        $dtd->routeing('token');
    }

    public function testTimetableCallsClient(): void
    {
        $client = $this->prophesize(Client::class);
        $dtd    = new DTD($client->reveal());

        $client->get('3.0/timetable', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(new Response(200, [], 'some text that is really a zip file...'))->shouldBeCalled();

        $dtd->timetable('token');
    }
}
