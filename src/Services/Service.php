<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Services;

use GuzzleHttp\Client;

abstract class Service
{
    public function __construct(
        private Client $client
    ) {
    }

    protected function call(string $url, string $token): string
    {
        $response = $this->client->get($url, [
            'headers' => [
                'X-Auth-Token' => $token,
            ],
        ]);

        return (string) $response->getBody();
    }
}
