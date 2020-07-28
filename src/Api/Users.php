<?php

namespace Sharetribe\Sdk\Api;

use Sharetribe\Sdk\Client;
use Sharetribe\Sdk\Result\Paginated;

class Users implements ApiInterface
{
    public const USERS_QUERY_URI = '/integration_api/users/query';
    public const USERS_SHOW_URI = '/integration_api/users/show';

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

    public function get(array $params = []): \Iterator
    {
        return new Paginated($this, 'query', $params);
    }

    public function show($id, array $params = []): array
    {
        $headers = [
            'Authorization' => 'bearer ' . $this->token->getAccessToken(),
            'Accept' => 'application/json',
        ];
        $params = ['id' => $id] + $params;
        return $this->client->call('GET', self::USERS_SHOW_URI, $params, $headers);
    }
}
