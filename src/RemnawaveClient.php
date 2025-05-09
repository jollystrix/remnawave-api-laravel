<?php

namespace Jollystrix\RemnawaveApi;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;
use Jollystrix\RemnawaveApi\Exceptions\ApiException;

class RemnawaveClient
{
    protected Client $client;
    protected string $apiKey;
    protected string $baseUrl;
    protected string $mode;
    protected array $defaultHeaders = [];

    public function __construct()
    {
        $this->apiKey = config('remnawave.api_key');
        $this->baseUrl = config('remnawave.base_url');
        $this->mode = config('remnawave.mode', 'local');

        // Определение протокола
        $protocol = 'http';
        if ($this->mode === 'https') {
            $protocol = 'https';
        }

        $this->baseUrl = $protocol . '://' . rtrim($this->baseUrl, '/') . '/api/';

        $options = [
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
            ],
        ];

        if ($this->mode === 'local') {
            $options[RequestOptions::VERIFY] = false;
        }

        $this->client = new Client($options);
    }

    public function get(string $endpoint, array $params = [], array $headers = []): array
    {
        return $this->request('GET', $endpoint, [
            'query' => $params,
            'headers' => array_merge($this->defaultHeaders, $headers),
        ]);
    }

    public function post(string $endpoint, array $data = [], array $headers = []): array
    {
        return $this->request('POST', $endpoint, [
            'json' => $data,
            'headers' => array_merge($this->defaultHeaders, $headers),
        ]);
    }

    public function put(string $endpoint, array $data = [], array $headers = []): array
    {
        return $this->request('PUT', $endpoint, [
            'json' => $data,
            'headers' => array_merge($this->defaultHeaders, $headers),
        ]);
    }

    public function delete(string $endpoint, array $headers = []): array
    {
        return $this->request('DELETE', $endpoint, [
            'headers' => array_merge($this->defaultHeaders, $headers),
        ]);
    }

    protected function request(string $method, string $endpoint, array $options = []): array
    {
        try {
            $response = $this->client->request($method, $endpoint, $options);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error("Remnawave API Error: " . $e->getMessage());
            throw new ApiException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
