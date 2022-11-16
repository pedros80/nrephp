<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Factories;

use Pedros80\NREphp\Factories\FileClientFactory;
use Pedros80\NREphp\Factories\HttpClientFactory;
use Pedros80\NREphp\Factories\SoapClientFactory;
use Pedros80\NREphp\Services\DTD;
use Pedros80\NREphp\Services\HSP;
use Pedros80\NREphp\Services\KB;
use Pedros80\NREphp\Services\LDB;
use Pedros80\NREphp\Services\PushPortFiles;
use Pedros80\NREphp\Services\TimetableFiles;
use Pedros80\NREphp\Services\TokenGenerator;

final class ServicesFactory
{
    public function makeLDB(string $key, bool $trace = false): LDB
    {
        $clientFactory = new SoapClientFactory();
        $client        = $clientFactory->make($key, $trace);

        return new LDB($client);
    }

    public function makeHSP(string $user, string $pass): HSP
    {
        $clientFactory = new HttpClientFactory();
        $client        = $clientFactory->makeHSPClient($user, $pass);

        return new HSP($client);
    }

    public function makePushPortFiles(string $user, string $pass): PushPortFiles
    {
        $clientFactory = new FileClientFactory();
        $client        = $clientFactory->makeFtp($user, $pass);

        return new PushPortFiles($client);
    }

    public function makeTimetableFiles(string $key, string $secret): TimetableFiles
    {
        $clientFactory = new FileClientFactory();
        $client        = $clientFactory->makeS3($key, $secret);

        return new TimetableFiles($client);
    }

    public function makeDTD(): DTD
    {
        $clientFactory = new HttpClientFactory();
        $client        = $clientFactory->makeClient();

        return new DTD($client);
    }

    public function makeKB(): KB
    {
        $clientFactory = new HttpClientFactory();
        $client        = $clientFactory->makeClient();

        return new KB($client);
    }

    public function makeTokenGenerator(): TokenGenerator
    {
        $clientFactory = new HttpClientFactory();
        $client        = $clientFactory->makeAuthClient();

        return new TokenGenerator($client);
    }
}
