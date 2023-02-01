<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Pedros80\NREphp\Exceptions\CouldNotGenerateToken;
use Pedros80\NREphp\Services\TokenGenerator;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

final class TokenGeneratorTest extends TestCase
{
    use ProphecyTrait;

    public function testTokenGeneratorCanBeInstantiated(): void
    {
        $client = $this->prophesize(Client::class);

        $tg = new TokenGenerator($client->reveal(), 'user', 'pass');

        $this->assertInstanceOf(TokenGenerator::class, $tg);
    }

    public function testValidResponseCanBeParsed(): void
    {
        $client = $this->prophesize(Client::class);

        $client->post('', [
            'form_params' => [
                'username' => 'username',
                'password' => 'password'
            ]
        ])->willReturn(new Response(200, [], '{"token":"username:1668153791000:access_token"}'));

        $tg    = new TokenGenerator($client->reveal(), 'username', 'password');
        $token = $tg->get();

        $this->assertIsArray($token);
        $this->assertEquals('username:1668153791000:access_token', $token['token']);
        $this->assertEquals('username', $token['user']);
        $this->assertEquals(date('Y-m-d H:i:s', 1668153791000 / 1000), $token['expires']);
    }

    public function testInvalidResponseThrowsException(): void
    {
        $this->expectException(CouldNotGenerateToken::class);
        $this->expectExceptionMessage('Problem with response');

        $client = $this->prophesize(Client::class);

        $client->post('', [
            'form_params' => [
                'username' => 'username',
                'password' => 'password'
            ]
        ])->willThrow(new Exception('Problem with response'));

        $tg = new TokenGenerator($client->reveal(), 'username', 'password');
        $tg->get();
    }
}
