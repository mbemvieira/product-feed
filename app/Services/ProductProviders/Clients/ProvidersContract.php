<?php

namespace App\Services\ProductProviders\Clients;

interface ProvidersContract
{
    public function send(
        string $httpMethod,
        string $endpoint,
        array $content = []
    );
}
