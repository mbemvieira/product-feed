<?php

namespace App\Services\ProductProviders\Clients;

class EBayClient extends AbstractClient
{
    public $baseUri = 'http://svcs.sandbox.ebay.com/';
    public $endpoints = [
        'findingService' => 'services/search/FindingService/v1',
    ];

    public function __construct()
    {
        parent::__construct($this->baseUri);

        $this->headers = [
            'X-EBAY-SOA-SERVICE-NAME' => 'FindingService',
            'X-EBAY-SOA-OPERATION-NAME' => 'findItemsByKeywords',
            'X-EBAY-SOA-SERVICE-VERSION' => '1.0.0',
            'X-EBAY-SOA-GLOBAL-ID' => 'EBAY-US',
            'X-EBAY-SOA-SECURITY-APPNAME' => env('EBAY_CREDENTIALS'),
            'X-EBAY-SOA-REQUEST-DATA-FORMAT' => 'JSON',
        ];
    }

    public function get(array $params = [])
    {
        $content = [
            'keywords' => $params['keywords'],
            'paginationInput' => [
                'entriesPerPage' => $params['entriesPerPage'] ?? 100,
                'pageNumber' => $params['pageNumber'] ?? 1,
            ]
        ];

        return parent::send('POST', $this->endpoints['findingService'], $content);
    }
}
