<?php

namespace Tests\Darwin\Factories;

use Pedros80\NREphp\Darwin\Factories\ServicesFactory;
use Pedros80\NREphp\Darwin\Services\HSP;
use Pedros80\NREphp\Darwin\Services\LDB;
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
}
