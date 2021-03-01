<?php

namespace App\Services\ProductProviders;

use App\Repositories\KeywordRepository;
use App\Repositories\ProductRepository;
use App\Services\ProductProviders\Clients\EBayClient;
use App\Services\ProductProviders\Mappers\EBayMapper;

class ProductProviderManager
{
    private $productRepository;
    private $keywordRepository;
    private $productProviders = [
        'eBay' => [
            'client' => EBayClient::class,
            'mapper' => EBayMapper::class,
        ]
    ];
    private $clientInstances = [];

    public function __construct(
        ProductRepository $productRepository,
        KeywordRepository $keywordRepository
    ) {
        $this->productRepository = $productRepository;
        $this->keywordRepository = $keywordRepository;

        foreach ($this->productProviders as $key => $provider) {
            $this->clientInstances[$key] = new $provider['client']();
        }
    }

    public function dispatch(array $parameters = [])
    {
        foreach ($this->productProviders as $key => $provider) {
            $response = $this->clientInstances[$key]->get($parameters);

            if ($response === null) continue;

            $mapper = new $provider['mapper']($response);

            if (!$mapper->isValidContent()) continue;

            $this->keywordRepository->updateOrCreate(['name' => $parameters['keywords']]);
            $this->productRepository->updateOrCreateMany($mapper->getProducts());
        }
    }
}
