<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Pedros80\NREphp\Factories\ServicesFactory;
use Pedros80\NREphp\Services\DTD;
use Pedros80\NREphp\Services\HSP;
use Pedros80\NREphp\Services\KB;
use Pedros80\NREphp\Services\LDB;
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

    public function testServicesFactoryCanMakeLDB(): void
    {
        $factory = new ServicesFactory();
        $ldb     = $factory->makeLDB('a_key');

        $this->assertInstanceOf(LDB::class, $ldb);
    }

    public function testServicesFactoryCanMakeHSP(): void
    {
        $factory = new ServicesFactory();
        $hsp     = $factory->makeHSP('user', 'pass');

        $this->assertInstanceOf(HSP::class, $hsp);
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
