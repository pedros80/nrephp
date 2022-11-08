<?php

namespace Pedros80\NREphp\Darwin\Factories;

use Pedros80\NREphp\Darwin\Factories\HttpClientFactory;
use Pedros80\NREphp\Darwin\Factories\SoapClientFactory;
use Pedros80\NREphp\Darwin\Services\HSP;
use Pedros80\NREphp\Darwin\Services\LDB;

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
}
