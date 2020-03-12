<?php

namespace Sharetribe\Sdk\Api;

use Sharetribe\Sdk\Client;
use Sharetribe\Sdk\Result\Paginated;

class Users implements ApiInterface
{
    const USERS_QUERY_URI = '/integration_api/users/query';

    protected $client;

    public function __construct(Client $client, Token $token)
    {
        $this->client = $client;
        $this->token = $token;
    }

    public function query(array $filters = [], array $params = []): array
    {
        $headers = [
            'Authorization' => 'bearer ' . $this->token->getAccessToken(),
            'Accept' => 'application/json',
        ];
        return $this->client->call('GET', self::USERS_QUERY_URI, $filters, $params, $headers);
    }

    public function getAll(): \Iterator
    {
        return new Paginated($this, 'query');
    }
}
