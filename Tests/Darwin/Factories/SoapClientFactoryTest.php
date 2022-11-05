<?php

namespace Tests\Darwin\Factories;

use Pedros80\NREphp\Darwin\Exceptions\LDBException;
use Pedros80\NREphp\Darwin\Factories\SoapClientFactory;
use Pedros80\NREphp\Darwin\LDB;
use PHPUnit\Framework\TestCase;
use SoapClient;

final class SoapClientFactoryTest extends TestCase
{
    public function testFactoryCanBeInstantiated(): void
    {
        $factory = new SoapClientFactory();
        $this->assertInstanceOf(SoapClientFactory::class, $factory);
    }

    public function testFactoryCanCreateSoapClient(): void
    {
        $factory = new SoapClientFactory();
        $client = $factory->make('blah blah blah');

        $this->assertInstanceOf(SoapClient::class, $client);
    }

    public function testInvalidKeyClientThrowsException(): void
    {
        $this->expectException(LDBException::class);

        $factory = new SoapClientFactory();
        $client = $factory->make('blah blah blah', true);

        $ldb = new LDB($client);

        $ldb->getServiceDetails('blah blah blah');
    }
}
