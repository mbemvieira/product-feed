<?php

namespace App\Services\ProductProviders\Clients;

interface ProvidersContract
{
    public function sendRequest(array $params = []);
}
