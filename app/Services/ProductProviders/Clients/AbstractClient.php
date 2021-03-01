<?php

namespace App\Services\ProductProviders\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

abstract class AbstractClient implements ProvidersContract
{
    protected $client = null;
    protected $headers = null;

    public function __construct(string $baseUri)
    {
        $this->client = new Client([
            'base_uri' => $baseUri
        ]);
    }

    public function send(
        string $httpMethod,
        string $endpoint,
        array $content = []
    ) {
        try {
            $body = [
                'headers' => $this->headers,
            ];

            if (count($content) > 0) {
                $body['json'] = $content;
            }

            $response = $this->client->request(
                $httpMethod,
                $endpoint,
                $body
            );

            return json_decode($response->getBody()->getContents());
        } catch (TransferException $e) {
            return null;
        }
    }
}
