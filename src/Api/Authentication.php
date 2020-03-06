<?php

namespace Sharetribe\Sdk\Api;

use Sharetribe\Sdk\Client;

class Authentication
{
    const AUTH_TOKEN_URI = '/auth/token';

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function authenticateBySecret($clientId, $secret): array
    {
        $params = [
            'grant_type' => 'client_credentials',
            'client_id' => $clientId,
            'client_secret' => $secret,
        ];

        return $this->authenticate($params);
    }

    public function authenticateByRefreshToken($refreshToken): array
    {
        $params = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken
        ];

        return $this->authenticate($params);
    }

    protected function authenticate(array $params): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8',
            'Accept' => 'application/json',
        ];
        return $this->client->call('POST', self::AUTH_TOKEN_URI, $params, $headers);
    }
}
