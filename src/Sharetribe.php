<?php

namespace Sharetribe\Sdk;

use Sharetribe\Sdk\Api\Authentication;
use Sharetribe\Sdk\Api\Users;
use Sharetribe\Sdk\Api\Listings;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

class Sharetribe
{
    const VERSION = '1.0.0';

    protected $client;

    protected $token;

    public function __construct($clientId, $clientSecret, $config = array())
    {
        if (empty($clientId)) {
            throw new SharetribeSDKException('An $clientId key is required to connecto to Sharetribe API');
        }
        if (empty($clientSecret)) {
            throw new SharetribeSDKException('An $clientSecret key is required to connecto to Sharetribe API');
        }
        $this->client = new Client();
        try {
            $auth = new Authentication($this->client);
            $this->token = new Api\Token($auth->authenticateBySecret($clientId, $clientSecret));
        } catch(\SharetribeSDKException $e) {
            echo 'Error to connect to Sharetribe';
        }
    }

    public function users(): Users
    {
        return new Users($this->client, $this->token);
    }

    public function listings(): Listings
    {
        return new Listings($this->client, $this->token);
    }
}
