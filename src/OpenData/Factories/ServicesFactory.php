<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin\Factories;

use Pedros80\NREphp\OpenData\DTD\DTD;
use Pedros80\NREphp\OpenData\Factories\HttpClientFactory;
use Pedros80\NREphp\OpenData\KnowledgeBase\KB;
use Pedros80\NREphp\OpenData\Services\TokenGenerator;

final class ServicesFactory
{
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
