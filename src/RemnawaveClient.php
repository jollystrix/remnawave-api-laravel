<?php

namespace Jollystrix\RemnawaveApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Str;
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
        $this->baseUrl = config('remnawave.base_url') . '/api/';

        if (blank($this->apiKey)) {
            throw new \Exception('API key is not set. Please check REMNAWAVE_API_KEY in the remnawave config or the .env file.');
        }

        if (!Str::startsWith($this->baseUrl, ['http://', 'https://']) || !filter_var($this->baseUrl, FILTER_VALIDATE_URL)) {
            throw new \Exception('REMNAWAVE_API_URL must be a valid domain with http or https. Please check the remnawave config or the .env file.');
        }

        $options = [
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
            ],
        ];

        if (Str::startsWith($this->baseUrl, 'http://')) {
            $options[RequestOptions::VERIFY] = false;
            $options['headers']['x-forwarded-for'] = '127.0.0.1';
            $options['headers']['x-forwarded-proto'] = 'https';
        }

        $this->client = new Client($options);
    }
    public function get(string $endpoint, array $data = [], array $headers = []): array
    {
        return $this->request('GET', $endpoint, [
            'query' => $data,
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

    public function patch(string $endpoint, array $data = [], array $headers = []): array
    {
        return $this->request('PATCH', $endpoint, [
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

    protected function request($method, $endpoint, $options): array
    {
        try {
            $response = $this->client->request($method, $endpoint, $options);
            return json_decode($response->getBody(), true) ?? [];
        } catch (RequestException $e) {
            $responseBody = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null;
            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : 500;

            return [
                'success' => false,
                'error' => $responseBody ? json_decode($responseBody, true) : null,
                'status_code' => $statusCode
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Internal Server Error',
                'status_code' => 500
            ];
        }
    }
}
