<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin\Factories;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

final class HttpClientFactory
{
    private const BASE_URI   = 'https://hsp-prod.rockshore.net/api/v1/';
    private const USER_AGENT = 'NREphp - test';

    public function make(string $user, string $pass): Client
    {
        $auth = base64_encode("{$user}:{$pass}");

        return new Client([
            'base_uri'               => self::BASE_URI,
            RequestOptions::HEADERS  => [
                'User-Agent'    => self::USER_AGENT,
                'Authorization' => "Basic {$auth}",
                'Content-Type'  => 'application/json',
            ],
            RequestOptions::TIMEOUT => 20,
        ]);
    }
}
