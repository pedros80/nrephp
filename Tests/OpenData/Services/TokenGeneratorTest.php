<?php

namespace Tests\OpenData\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Pedros80\NREphp\OpenData\Exceptions\CouldNotGenerateToken;
use Pedros80\NREphp\OpenData\Services\TokenGenerator;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

final class TokenGeneratorTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy $client;

    public function setUp(): void
    {
        $this->client = $this->prophesize(Client::class);
    }

    public function testTokenGeneratorCanBeInstantiated(): void
    {
        $tg = new TokenGenerator($this->client->reveal());

        $this->assertInstanceOf(TokenGenerator::class, $tg);
    }

    public function testValidResponseCanBeParsed(): void
    {
        $this->client->post('', [
            'form_params' => [
                'username' => 'username',
                'password' => 'password'
            ]
        ])->willReturn(new Response(200, [], json_encode(['token' => 'username:1668153791000:access_token'])));

        $tg = new TokenGenerator($this->client->reveal());

        $token = $tg->get('username', 'password');

        $this->assertIsArray($token);
        $this->assertEquals('username:1668153791000:access_token', $token['token']);
        $this->assertEquals('username', $token['user']);
        $this->assertEquals(date('Y-m-d H:i:s', 1668153791000 / 1000), $token['expires']);
    }

    public function testInvalidResponseThrowsException(): void
    {
        $this->expectException(CouldNotGenerateToken::class);
        $this->expectExceptionMessage('Problem with response');

        $this->client->post('', [
            'form_params' => [
                'username' => 'username',
                'password' => 'password'
            ]
        ])->willThrow(new Exception('Problem with response'));

        $tg = new TokenGenerator($this->client->reveal());
        $tg->get('username', 'password');
    }
}
