<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin\Factories;

use Pedros80\NREphp\Darwin\Factories\FileClientFactory;
use Pedros80\NREphp\Darwin\Factories\HttpClientFactory;
use Pedros80\NREphp\Darwin\Factories\SoapClientFactory;
use Pedros80\NREphp\Darwin\Services\HSP;
use Pedros80\NREphp\Darwin\Services\LDB;
use Pedros80\NREphp\Darwin\Services\PushPortFtp;
use Pedros80\NREphp\Darwin\Services\TimetableFiles;

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
        $client        = $clientFactory->make($user, $pass);

        return new HSP($client);
    }

    public function makePushPortFtp(string $user, string $pass): PushPortFtp
    {
        $clientFactory = new FileClientFactory();
        $client        = $clientFactory->makeFtp($user, $pass);

        return new PushPortFtp($client);
    }

    public function makeTimetableFiles(string $key, string $secret): TimetableFiles
    {
        $clientFactory = new FileClientFactory();
        $client        = $clientFactory->makeS3($key, $secret);

        return new TimetableFiles($client);
    }
}
