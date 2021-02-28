<?php

namespace App\Services\ProductProviders\Clients;

use GuzzleHttp\Client;

abstract class AbstractClient implements ProvidersContract
{
    public $client = null;

    public function __construct(string $baseUri)
    {
        $this->client = new Client([
            'base_uri' => $baseUri
        ]);
    }
}
