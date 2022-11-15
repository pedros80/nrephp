<?php

declare(strict_types=1);

namespace Tests\Darwin\Factories;

use Pedros80\NREphp\Darwin\Factories\ServicesFactory;
use Pedros80\NREphp\Darwin\Services\HSP;
use Pedros80\NREphp\Darwin\Services\LDB;
use Pedros80\NREphp\Darwin\Services\PushPortFiles;
use Pedros80\NREphp\Darwin\Services\TimetableFiles;
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
}
