<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Factories;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

final class HttpClientFactory
{
    private const HSP_URI    = 'https://hsp-prod.rockshore.net/api/v1/';
    private const USER_AGENT = 'NREphp';
    private const AUTH_URI   = 'https://opendata.nationalrail.co.uk/authenticate';
    private const API_URI    = 'https://opendata.nationalrail.co.uk/api/staticfeeds/';
    private const TIMEOUT    = 20;

    public function makeHSPClient(string $user, string $pass): Client
    {
        $auth = base64_encode("{$user}:{$pass}");

        return new Client([
            'base_uri'               => self::HSP_URI,
            RequestOptions::HEADERS  => [
                'User-Agent'    => self::USER_AGENT,
                'Authorization' => "Basic {$auth}",
                'Content-Type'  => 'application/json',
            ],
            RequestOptions::TIMEOUT => self::TIMEOUT,
        ]);
    }

    public function makeAuthClient(): Client
    {
        return new Client([
            'base_uri'               => self::AUTH_URI,
            RequestOptions::HEADERS  => [
                'User-Agent'   => self::USER_AGENT,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            RequestOptions::TIMEOUT => self::TIMEOUT,
        ]);
    }

    public function makeClient(): Client
    {
        return new Client([
            'base_uri'              => self::API_URI,
            RequestOptions::HEADERS => [
                'User-Agent' => self::USER_AGENT,
            ],
            RequestOptions::TIMEOUT => self::TIMEOUT,
        ]);
    }
}
