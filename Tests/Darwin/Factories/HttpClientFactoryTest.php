<?php

declare(strict_types=1);

namespace Tests\Darwin\Factories;

use GuzzleHttp\Client;
use Pedros80\NREphp\Darwin\Factories\HttpClientFactory;
use PHPUnit\Framework\TestCase;

final class HttpClientFactoryTest extends TestCase
{
    public function testHttpClientFactoryCanBeInstantiated(): void
    {
        $factory = new HttpClientFactory();

        $this->assertInstanceOf(HttpClientFactory::class, $factory);
    }

    public function testFactoryCanCreateAClient(): void
    {
        $factory = new HttpClientFactory();
        $client = $factory->make('user', 'pass');

        $this->assertInstanceOf(Client::class, $client);
    }
}
