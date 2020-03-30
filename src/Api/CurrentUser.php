<?php

namespace Sharetribe\Sdk\Api;

use Sharetribe\Sdk\Client;

class CurrentUser implements ApiInterface
{
    const CURRENT_USER = '/api/current_user';

    protected $client;

    public function __construct(Client $client, Token $token)
    {
        $this->client = $client;
        $this->token = $token;
    }

    public function show(array $params = []): array
    {
        if (isset($params['baerer'])) {
            $baerer = $params['baerer'];
        } else {
            $baerer = $this->token->getAccessToken();
        }
        $headers = [
            'Authorization' => 'bearer ' . $baerer,
            'Accept' => 'application/json',
        ];
        return $this->client->call('GET', self::CURRENT_USER . '/show', $filters, $params, $headers);
    }

}