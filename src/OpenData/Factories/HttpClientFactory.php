<?php

declare(strict_types=1);

namespace Pedros80\NREphp\OpenData\Factories;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

final class HttpClientFactory
{
    private const AUTH_URI   = 'https://opendata.nationalrail.co.uk/authenticate';
    private const USER_AGENT = 'NREphp';
    private const API_URI    = 'https://opendata.nationalrail.co.uk/api/staticfeeds/';

    public function makeAuthClient(): Client
    {
        return new Client([
            'base_uri'               => self::AUTH_URI,
            RequestOptions::HEADERS  => [
                'User-Agent'   => self::USER_AGENT,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            RequestOptions::TIMEOUT => 20,
        ]);
    }

    public function makeClient(): Client
    {
        return new Client([
            'base_uri'              => self::API_URI,
            RequestOptions::HEADERS => [
                'User-Agent' => self::USER_AGENT,
            ],
            RequestOptions::TIMEOUT => 20,
        ]);
    }
}
