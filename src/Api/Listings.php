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

    public function query(array $params = []): array
    {
        $headers = [
            'Authorization' => 'bearer ' . $this->token->getAccessToken(),
            'Accept' => 'application/json',
        ];
        return $this->client->call('GET', self::LISTINGS_QUERY_URI, $params, $headers);
    }

    public function show($id, array $params = []): array {
        $headers = [
            'Authorization' => 'bearer ' . $this->token->getAccessToken(),
            'Accept' => 'application/json',
        ];
        if ($params) {
            foreach ($params as $name => $param) {
                $params[$name] = implode(',', $param);
            }
        }
        $params = ['id' => $id] + $params;
        return $this->client->call('GET', self::LISTINGS_SHOW_URI, $params, $headers);
    }

    public function get(array $params = []): \Iterator
    {
        return new Paginated($this, 'query', $params);
    }

    public function getAll(): \Iterator
    {
        return new Paginated($this, 'query');
    }
}
