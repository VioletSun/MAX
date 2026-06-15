<?php

namespace VioletSun\MAX;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class Client
{
    protected GuzzleClient $http;
    protected ?string $apiKey;

    public function __construct(
        string $baseUri,
        ?string $apiKey = null,
        float $timeout = 10.0,
        array $headers = []
    ) {
        $this->apiKey = $apiKey;

        $defaultHeaders = array_filter([
            'Accept' => 'application/json',
            'Authorization' => $apiKey ? 'Bearer ' . $apiKey : null,
        ]);

        $this->http = new GuzzleClient([
            'base_uri' => rtrim($baseUri, '/') . '/',
            'timeout' => $timeout,
            'headers' => array_merge($defaultHeaders, $headers),
        ]);
    }

    public function get(string $uri, array $query = []): array
    {
        return $this->request('GET', $uri, ['query' => $query]);
    }

    public function post(string $uri, array $data = [], array $query = []): array
    {
        return $this->request('POST', $uri, [
            'json' => $data,
            'query' => $query,
        ]);
    }

    public function put(string $uri, array $data = [], array $query = []): array
    {
        return $this->request('PUT', $uri, [
            'json' => $data,
            'query' => $query,
        ]);
    }

    public function delete(string $uri, array $query = []): array
    {
        return $this->request('DELETE', $uri, ['query' => $query]);
    }

    protected function request(string $method, string $uri, array $options = []): array
    {
        try {
            $response = $this->http->request($method, ltrim($uri, '/'), $options);
            $body = (string) $response->getBody();
            $decoded = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return ['status' => $response->getStatusCode(), 'body' => $body];
            }

            return $decoded ?? [];
        } catch (GuzzleException $e) {
            return ['status' => false, 'error' => $e->getMessage()];
        }
    }
}
