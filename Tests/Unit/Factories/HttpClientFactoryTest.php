<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use GuzzleHttp\Client;
use Pedros80\NREphp\Factories\HttpClientFactory;
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
        $client = $factory->makeHSPClient('user', 'pass');

        $this->assertInstanceOf(Client::class, $client);
    }

    public function testFactoryInstantiates(): void
    {
        $factory = new HttpClientFactory();

        $this->assertInstanceOf(HttpClientFactory::class, $factory);
    }

    public function testFactoryCanMakeAuthClient(): void
    {
        $factory = new HttpClientFactory();

        $client = $factory->makeAuthClient();

        $this->assertInstanceOf(Client::class, $client);
    }

    public function testFactoryCanMakeAPIClient(): void
    {
        $factory = new HttpClientFactory();

        $client = $factory->makeClient();

        $this->assertInstanceOf(Client::class, $client);
    }
}
