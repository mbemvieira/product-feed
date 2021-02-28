<?php

namespace App\Services\ProductProviders;

use GuzzleHttp\Client;

abstract class HttpClient implements ProvidersContract
{
    public $client = null;

    public function __construct(string $baseUri)
    {
        $this->client = new Client([
            'base_uri' => $baseUri
        ]);
    }
}
