<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Pedros80\NREphp\Factories\ServicesFactory;
use Pedros80\NREphp\Services\DTD;
use Pedros80\NREphp\Services\HistoricalServicePerformance;
use Pedros80\NREphp\Services\KnowledgeBase;
use Pedros80\NREphp\Services\LiveDepartureBoard;
use Pedros80\NREphp\Services\PushPortFiles;
use Pedros80\NREphp\Services\TimetableFiles;
use Pedros80\NREphp\Services\TokenGenerator;
use PHPUnit\Framework\TestCase;

final class ServicesFactoryTest extends TestCase
{
    public function testServicesFactoryCanBeInstantiated(): void
    {
        $factory = new ServicesFactory();

        $this->assertInstanceOf(ServicesFactory::class, $factory);
    }

    public function testServicesFactoryCanMakeLiveDepartureBoard(): void
    {
        $factory = new ServicesFactory();
        $ldb     = $factory->makeLiveDepartureBoard('a_key');

        $this->assertInstanceOf(LiveDepartureBoard::class, $ldb);
    }

    public function testServicesFactoryCanMakeHistoricalServicePerformance(): void
    {
        $factory = new ServicesFactory();
        $hsp     = $factory->makeHistoricalServicePerformance('user', 'pass');

        $this->assertInstanceOf(HistoricalServicePerformance::class, $hsp);
    }

    public function testServicesFactoryCanMakePushPortFiles(): void
    {
        $factory = new ServicesFactory();
        $ppf     = $factory->makePushPortFiles('user', 'pass');

        $this->assertInstanceOf(PushPortFiles::class, $ppf);
    }

    public function testServicesFactoryCanMakeTimetableFiles(): void
    {
        $factory = new ServicesFactory();
        $ttf     = $factory->makeTimetableFiles('key', 'secret');

        $this->assertInstanceOf(TimetableFiles::class, $ttf);
    }

    public function testServicesFactoryCanMakeDTD(): void
    {
        $factory = new ServicesFactory();
        $dtd     = $factory->makeDTD();

        $this->assertInstanceOf(DTD::class, $dtd);
    }

    public function testServicesFactoryCanMakeKnowledgeBase(): void
    {
        $factory = new ServicesFactory();
        $kb      = $factory->makeKnowledgeBase();

        $this->assertInstanceOf(KnowledgeBase::class, $kb);
    }

    public function testServicesFactoryCanMakeTokenGenerator(): void
    {
        $factory        = new ServicesFactory();
        $tokenGenerator = $factory->makeTokenGenerator('user', 'pass');

        $this->assertInstanceOf(TokenGenerator::class, $tokenGenerator);
    }
}
