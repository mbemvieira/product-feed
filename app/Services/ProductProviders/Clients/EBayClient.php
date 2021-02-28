<?php

namespace App\Services\ProductProviders\Clients;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\TransferException;

class EBayClient extends AbstractClient
{
    public $baseUri = 'http://svcs.sandbox.ebay.com/';
    public $endpoints = [
        'findingService' => 'services/search/FindingService/v1',
    ];
    public $headers = null;

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

    public function sendRequest(array $params = [])
    {
        $content = [
            'keywords' => $params['keywords'],
            'paginationInput' => [
                'entriesPerPage' => $params['entriesPerPage'] ?? 100,
                'pageNumber' => $params['pageNumber'] ?? 1,
            ]
        ];

        try {
            $response = $this->client->request(
                'POST',
                $this->endpoints['findingService'],
                [
                    'headers' => $this->headers,
                    'json' => $content,
                ]
            );

            return $response->getBody()->getContents();
        } catch (TransferException $e) {
            // echo Psr7\Message::toString($e->getResponse());
            // if ($e->hasResponse()) {
            //     echo Psr7\Message::toString($e->getResponse());
            // }
            return null;
        }
    }
}
