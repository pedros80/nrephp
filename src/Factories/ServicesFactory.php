<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Factories;

use Pedros80\NREphp\Factories\FileClientFactory;
use Pedros80\NREphp\Factories\HttpClientFactory;
use Pedros80\NREphp\Factories\SoapClientFactory;
use Pedros80\NREphp\Services\DTD;
use Pedros80\NREphp\Services\HistoricalServicePerformance;
use Pedros80\NREphp\Services\KnowledgeBase;
use Pedros80\NREphp\Services\LiveDepartureBoard;
use Pedros80\NREphp\Services\PushPortFiles;
use Pedros80\NREphp\Services\TimetableFiles;
use Pedros80\NREphp\Services\TokenGenerator;

final class ServicesFactory
{
    public function makeLiveDepartureBoard(string $key, bool $trace = false): LiveDepartureBoard
    {
        $clientFactory = new SoapClientFactory();
        $client        = $clientFactory->make($key, $trace);

        return new LiveDepartureBoard($client);
    }

    public function makeHistoricalServicePerformance(string $user, string $pass): HistoricalServicePerformance
    {
        $clientFactory = new HttpClientFactory();
        $client        = $clientFactory->makeHistoricalServicePerformanceClient($user, $pass);

        return new HistoricalServicePerformance($client);
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

    public function makeKnowledgeBase(): KnowledgeBase
    {
        $clientFactory = new HttpClientFactory();
        $client        = $clientFactory->makeClient();

        return new KnowledgeBase($client);
    }

    public function makeTokenGenerator(): TokenGenerator
    {
        $clientFactory = new HttpClientFactory();
        $client        = $clientFactory->makeAuthClient();

        return new TokenGenerator($client);
    }
}
