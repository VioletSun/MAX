<?php

namespace VioletSun\MAX;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class Client
{
    protected GuzzleClient $http;
    protected ?string $apiKey;
    protected bool $saveData;
    protected bool $enqueue;

    public function __construct(
        ?string $baseUri = 'https://platform-api.max.ru',
        ?string $apiKey = null,
        ?int $timeout = 10,
        ?bool $saveData = false,
        ?bool $enqueue = false
    ) {
        $this->apiKey = $apiKey;
        $this->saveData = $saveData;
        $this->enqueue = $enqueue;

        $this->http = new GuzzleClient([
            'base_uri' => rtrim($baseUri, '/') . '/',
            'timeout' => $timeout,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $apiKey ?? null,
            ],
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

            if (count($decoded) > 0 && $uri === 'updates') {
                $decoded['save_data'] = $this->saveData;
                $decoded['enqueue'] = $this->enqueue;
            }
            return $decoded ?? [];
        } catch (GuzzleException $e) {
            $message = $e->getMessage();
            if (str_contains($message, 'Operation timed out')) {
                return [];
            }
            return ['status' => false, 'error' => $message];
        }
    }
}
