<?php

declare(strict_types=1);

namespace Tests\OpenData\Factories;

use Pedros80\NREphp\OpenData\DTD\DTD;
use Pedros80\NREphp\OpenData\Factories\ServicesFactory;
use Pedros80\NREphp\OpenData\KnowledgeBase\KB;
use Pedros80\NREphp\OpenData\Services\TokenGenerator;
use PHPUnit\Framework\TestCase;

final class ServicesFactoryTest extends TestCase
{
    public function testServicesFactoryCanBeInstantiated(): void
    {
        $factory = new ServicesFactory();

        $this->assertInstanceOf(ServicesFactory::class, $factory);
    }

    public function testServicesFactoryCanMakeDTD(): void
    {
        $factory = new ServicesFactory();
        $dtd     = $factory->makeDTD();

        $this->assertInstanceOf(DTD::class, $dtd);
    }

    public function testServicesFactoryCanMakeKB(): void
    {
        $factory = new ServicesFactory();
        $kb      = $factory->makeKB();

        $this->assertInstanceOf(KB::class, $kb);
    }

    public function testServicesFactoryCanMakeTokenGenerator(): void
    {
        $factory        = new ServicesFactory();
        $tokenGenerator = $factory->makeTokenGenerator();

        $this->assertInstanceOf(TokenGenerator::class, $tokenGenerator);
    }
}
