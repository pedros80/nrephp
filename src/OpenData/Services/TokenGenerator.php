<?php

namespace Pedros80\NREphp\OpenData\Services;

use GuzzleHttp\Client;
use Pedros80\NREphp\OpenData\Exceptions\CouldNotGenerateToken;
use Throwable;

final class TokenGenerator
{
    public function __construct(
        private Client $client
    ) {
    }

    public function get(string $user, string $pass): array
    {
        try {
            $response = $this->client->post('', [
                'form_params' => [
                    'username' => $user,
                    'password' => $pass,
                ],
            ]);

            $data  = json_decode((string) $response->getBody());
            $token = $this->parseToken($data->token);

            return $token;
        } catch (Throwable $e) {
            throw new CouldNotGenerateToken($e->getMessage());
        }
    }

    private function parseToken(string $token): array
    {
        [$user, $timestamp, $token] = explode(':', $token);

        return [
            'user'    => $user,
            'expires' => date('Y-m-d H:i:s', (int) $timestamp / 1000),
            'token'   => "{$user}:{$timestamp}:{$token}",
        ];
    }
}
