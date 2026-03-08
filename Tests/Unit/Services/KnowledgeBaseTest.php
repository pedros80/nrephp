<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Pedros80\NREphp\Services\KnowledgeBase;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

final class KnowledgeBaseTest extends TestCase
{
    use ProphecyTrait;

    /** @var ObjectProphecy<Client> */
    private ObjectProphecy $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = $this->prophesize(Client::class);
    }

    public function testServiceIndicatorsReturnsAString(): void
    {
        $kb = $this->makeKnowledgeBase();

        $this->client->get('4.0/serviceIndicators', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(
            new Response(200, [], '<some><xml></xml></some>')
        )->shouldBeCalled();

        $kb->serviceIndicators('token');
    }

    public function testIncidentsReturnsAString(): void
    {
        $kb = $this->makeKnowledgeBase();

        $this->client->get('5.0/incidents', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(
            new Response(200, [], '<some><xml></xml></some>')
        )->shouldBeCalled();

        $kb->incidents('token');
    }

    public function testTocsReturnsAString(): void
    {
        $kb = $this->makeKnowledgeBase();

        $this->client->get('4.0/tocs', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(
            new Response(200, [], '<some><xml></xml></some>')
        )->shouldBeCalled();

        $kb->tocs('token');
    }

    public function testTicketRestrictionsReturnsAString(): void
    {
        $kb = $this->makeKnowledgeBase();

        $this->client->get('4.0/ticket-restrictions', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(
            new Response(200, [], '<some><xml></xml></some>')
        )->shouldBeCalled();

        $kb->ticketRestrictions('token');
    }

    public function testTicketTypesReturnsAString(): void
    {
        $kb = $this->makeKnowledgeBase();

        $this->client->get('4.0/ticket-types', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(
            new Response(200, [], '<some><xml></xml></some>')
        )->shouldBeCalled();

        $kb->ticketTypes('token');
    }

    public function testPublicPromotionsReturnsAString(): void
    {
        $kb = $this->makeKnowledgeBase();

        $this->client->get('4.0/promotions-publics', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(
            new Response(200, [], '<some><xml></xml></some>')
        )->shouldBeCalled();

        $kb->publicPromotions('token');
    }

    public function testStationsReturnsAString(): void
    {
        $kb = $this->makeKnowledgeBase();

        $this->client->get('4.0/stations', [
            'headers' => [
                'X-Auth-Token' => 'token',
            ]
        ])->willReturn(
            new Response(200, [], '<some><xml></xml></some>')
        )->shouldBeCalled();

        $kb->stations('token');
    }

    private function makeKnowledgeBase(): KnowledgeBase
    {
        return new KnowledgeBase($this->client->reveal());
    }
}
