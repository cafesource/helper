<?php

namespace Cafesource\Helper\HttpClients;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Exception\RequestException;

/**
 * Class GuzzleHttpClient.
 */
class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * HTTP client.
     *
     * @var Client
     */
    protected $client;

    /**
     * @var PromiseInterface[]
     */
    private static $promises = [];

    /**
     * Timeout of the request in seconds.
     *
     * @var int
     */
    protected int $timeOut = 30;

    /**
     * Connection timeout of the request in seconds.
     *
     * @var int
     */
    protected int $connectTimeOut = 10;

    /**
     * @param Client|null $client
     */
    public function __construct( Client $client = null )
    {
        $this->client = $client ?: new Client();
    }

    /**
     * Unwrap Promises.
     *
     * @throws \Throwable
     */
    public function __destruct()
    {
        Promise\unwrap(self::$promises);
    }

    /**
     * Sets HTTP client.
     *
     * @param Client $client
     *
     * @return GuzzleHttpClient
     */
    public function setClient( Client $client ) : GuzzleHttpClient
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Gets HTTP client for internal class use.
     *
     * @return Client
     */
    private function getClient()
    {
        return $this->client;
    }

    /**
     * {@inheritdoc}
     */
    public function send(
        $url,
        $method,
        array $headers = [],
        array $options = [],
        $timeOut = 30,
        $isAsyncRequest = false,
        $connectTimeOut = 10
    )
    {
        $this->timeOut        = $timeOut;
        $this->connectTimeOut = $connectTimeOut;

        $body    = $options[ 'body' ] ?? null;
        $options = $this->getOptions($headers, $body, $options, $timeOut, $isAsyncRequest, $connectTimeOut);

        try {
            $response = $this->getClient()->requestAsync($method, $url, $options);

            if ( $isAsyncRequest ) {
                self::$promises[] = $response;
            } else {
                $response = $response->wait();
            }
        }
        catch ( RequestException $e ) {
            $response = $e->getResponse();

            if ( !$response instanceof ResponseInterface ) {
                throw new Exception($e->getMessage(), $e->getCode());
            }
        }

        return $response;
    }

    /**
     * Prepares and returns request options.
     *
     * @param array $headers
     * @param       $body
     * @param       $options
     * @param       $timeOut
     * @param       $isAsyncRequest
     * @param int   $connectTimeOut
     *
     * @return array
     */
    private function getOptions( array $headers, $body, $options, $timeOut, $isAsyncRequest = false, $connectTimeOut = 10 ) : array
    {
        $default_options = [
            RequestOptions::HEADERS         => $headers,
            RequestOptions::BODY            => $body,
            RequestOptions::TIMEOUT         => $timeOut,
            RequestOptions::CONNECT_TIMEOUT => $connectTimeOut,
            RequestOptions::SYNCHRONOUS     => !$isAsyncRequest,
        ];

        return array_merge($default_options, $options);
    }

    /**
     * @return int
     */
    public function getTimeOut() : int
    {
        return $this->timeOut;
    }

    /**
     * @return int
     */
    public function getConnectTimeOut() : int
    {
        return $this->connectTimeOut;
    }
}