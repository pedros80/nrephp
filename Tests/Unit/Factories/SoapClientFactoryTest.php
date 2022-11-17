<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Pedros80\NREphp\Exceptions\LiveDepartureBoard\LiveDepartureBoardException;
use Pedros80\NREphp\Factories\SoapClientFactory;
use Pedros80\NREphp\Services\LiveDepartureBoard;
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
        $this->expectException(LiveDepartureBoardException::class);

        $factory = new SoapClientFactory();
        $client = $factory->make('blah blah blah', true);

        $ldb = new LiveDepartureBoard($client);

        $ldb->getServiceDetails('blah blah blah');
    }
}
