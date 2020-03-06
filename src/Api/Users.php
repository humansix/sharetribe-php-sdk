<?php

namespace Sharetribe\Sdk\Api;

use Sharetribe\Sdk\Client;

class Users
{
    const USERS_QUERY_URI = '/integration_api/users/query';

    protected $client;

    public function __construct(Client $client, Token $token)
    {
        $this->client = $client;
        $this->token = $token;
    }

    public function query(array $params = []): array
    {
    	$headers = [
    		'Authorization' => 'bearer ' . $this->token->getAccessToken(),
    		'Accept' => 'application/json',
    	];
        return $this->client->call('GET', self::USERS_QUERY_URI, $params, $headers);
    }
}
