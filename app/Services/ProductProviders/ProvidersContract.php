<?php

namespace App\Services\ProductProviders;

interface ProvidersContract
{
    public function sendRequest(array $params = []);
}
