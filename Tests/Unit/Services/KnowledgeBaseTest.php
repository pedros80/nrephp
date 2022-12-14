<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Pedros80\NREphp\Services\KnowledgeBase;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

final class KnowledgeBaseTest extends TestCase
{
    use ProphecyTrait;

    public function testKnowledgeBaseCanBeInstantiated(): void
    {
        $client = $this->prophesize(Client::class);
        $kb     = new KnowledgeBase($client->reveal());

        $this->assertInstanceOf(KnowledgeBase::class, $kb);
    }

    public function testServiceIndicatorsReturnsAString(): void
    {
        $client = $this->prophesize(Client::class);
        $kb     = new KnowledgeBase($client->reveal());

        $client->get('4.0/serviceIndicators', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(new Response(200, [], '<some><xml></xml></some>'));

        $result = $kb->serviceIndicators('token');

        $this->assertIsString($result);
    }

    public function testIncidentsReturnsAString(): void
    {
        $client = $this->prophesize(Client::class);
        $kb     = new KnowledgeBase($client->reveal());

        $client->get('5.0/incidents', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(new Response(200, [], '<some><xml></xml></some>'));

        $result = $kb->incidents('token');

        $this->assertIsString($result);
    }

    public function testTocsReturnsAString(): void
    {
        $client = $this->prophesize(Client::class);
        $kb     = new KnowledgeBase($client->reveal());

        $client->get('4.0/tocs', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(new Response(200, [], '<some><xml></xml></some>'));

        $result = $kb->tocs('token');

        $this->assertIsString($result);
    }

    public function testTicketRestrictionsReturnsAString(): void
    {
        $client = $this->prophesize(Client::class);
        $kb     = new KnowledgeBase($client->reveal());

        $client->get('4.0/ticket-restrictions', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(new Response(200, [], '<some><xml></xml></some>'));

        $result = $kb->ticketRestrictions('token');

        $this->assertIsString($result);
    }

    public function testTicketTypesReturnsAString(): void
    {
        $client = $this->prophesize(Client::class);
        $kb     = new KnowledgeBase($client->reveal());

        $client->get('4.0/ticket-types', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(new Response(200, [], '<some><xml></xml></some>'));

        $result = $kb->ticketTypes('token');

        $this->assertIsString($result);
    }

    public function testPublicPromotionsReturnsAString(): void
    {
        $client = $this->prophesize(Client::class);
        $kb     = new KnowledgeBase($client->reveal());

        $client->get('4.0/promotions-publics', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(new Response(200, [], '<some><xml></xml></some>'));

        $result = $kb->publicPromotions('token');

        $this->assertIsString($result);
    }

    public function testStationsReturnsAString(): void
    {
        $client = $this->prophesize(Client::class);
        $kb     = new KnowledgeBase($client->reveal());

        $client->get('4.0/stations', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(new Response(200, [], '<some><xml></xml></some>'));

        $result = $kb->stations('token');

        $this->assertIsString($result);
    }
}
