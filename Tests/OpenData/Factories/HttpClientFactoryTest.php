<?php

namespace Tests\OpenData\Factories;

use GuzzleHttp\Client;
use Pedros80\NREphp\OpenData\Factories\HttpClientFactory;
use PHPUnit\Framework\TestCase;

final class HttpClientFactoryTest extends TestCase
{
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
