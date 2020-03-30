<?php

namespace Sharetribe\Sdk\Api;

use Sharetribe\Sdk\Client;
use Sharetribe\Sdk\Result\Paginated;

class Listings implements ApiInterface
{
    const LISTINGS_QUERY_URI = '/integration_api/listings/query';
    const LISTINGS_SHOW_URI = '/integration_api/listings/show';

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
        return $this->client->call('GET', self::LISTINGS_QUERY_URI, $filters, $params, $headers);
    }

    public function show($id): array {
        $headers = [
            'Authorization' => 'bearer ' . $this->token->getAccessToken(),
            'Accept' => 'application/json',
        ];
        return $this->client->call('GET', self::LISTINGS_SHOW_URI, ['id' => $id], [], $headers);
    }

    public function getAll(): \Iterator
    {
        return new Paginated($this, 'query');
    }
}
