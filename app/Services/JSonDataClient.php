<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class JSonDataClient extends Client
{
    protected string $key;

    protected string $endpoint;

    protected $options = [
        'url' => '',
    ];

    public function __construct(array $config = [])
    {

        $this->key = config('services.json.key');
        $this->endpoint = config('services.json.url');

        parent::__construct(array_merge([
            'base_uri' => $this->endpoint,

        ], $config));

    }

    /**
     * Get comments
     *
     * @throws GuzzleException
     */
    public function comments(string $method = 'GET', string $uri = 'comments', array $options = []): mixed
    {
        return $this->sends($method, $uri, $options);
    }

    /**
     * @throws GuzzleException
     */
    public function posts(string $method = 'GET', string $uri = 'posts', array $options = []): mixed
    {
        return $this->sends($method, $uri, $options);
    }

    /**
     * Get users
     */
    public function users(string $method = 'GET', string $uri = 'users', array $options = []): mixed
    {
        return $this->sends($method, $uri, $options);
    }

    /**
     * Default request handler
     *
     * @throws GuzzleException
     */
    public function sends(string $method, string $uri, array $options = []): mixed
    {

        $response = $this->request(
            $method,
            $uri,
            $this->filter(
                [
                    'query' => $options,
                    'headers' => [
                        'apikey' => $this->key,
                        'Content-Type' => 'text/plain',
                        'Accept' => 'application/json',
                    ],
                ]
            )
        )->getBody();

        return $this->prepareResponse($response);
    }

    protected function filter(array $data): array
    {
        return array_filter(
            array_merge(
                $data
            )
        );
    }

    /**
     * Get json response of the request
     */
    private function prepareResponse($response): mixed
    {
        return json_decode($response->getContents());
    }
}
