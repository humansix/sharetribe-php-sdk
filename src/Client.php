<?php

namespace Sharetribe\Sdk;

use Sharetribe\Sdk\Exception\SharetribeSDKException;
use Psr\Http\Message\ResponseInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Client implements LoggerAwareInterface
{

    const SHARETRIBE_INTEGRATION_API = 'https://flex-api.sharetribe.com/v1';

    protected $config = [];

    protected $httpClient = null;

    protected $requestFactory = null;

    protected $streamFactory = null;

    public function __construct($config = [])
    {
        $this->config = $config;
        $this->httpClient = $this->getHttpClient();
        $this->requestFactory = $this->getRequestFactory();
        $this->streamFactory = $this->getStreamFactory();
        $this->logger = new NullLogger();
    }


    public function call($httpMethod, $uri, $filters = null, $params = null, $headers = null): array
    {
        if (null !== $filters && is_array($filters)) {
            $uri .= '?' . http_build_query($filters, '', ',');
        }

        $request = $this->requestFactory->createRequest($httpMethod, self::SHARETRIBE_INTEGRATION_API . $uri);

        if (null !== $params && is_array($params)) {
            $request = $request->withBody($this->streamFactory->createStream(http_build_query($params)));
        }

        if (null !== $params && is_string($params)) {
            $request = $request->withBody($this->streamFactory->createStream($params));
        }

        if ($headers && is_array($headers)) {
            foreach ($headers as $header => $content) {
                $request = $request->withHeader($header, $content);
            }
        }

        $response = $this->httpClient->sendRequest($request);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    private function getHttpClient(): ClientInterface
    {
        return Psr18ClientDiscovery::find();
    }

    private function getRequestFactory(): RequestFactoryInterface
    {
        return Psr17FactoryDiscovery::findRequestFactory();
    }

    private function getStreamFactory(): StreamFactoryInterface
    {
        return Psr17FactoryDiscovery::findStreamFactory();
    }
}