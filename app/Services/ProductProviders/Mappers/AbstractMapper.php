<?php

namespace App\Services\ProductProviders\Mappers;

abstract class AbstractMapper
{
    protected $pagination = [
        'page' => 0,
        'itemsPerPage' => 0,
        'totalPages' => 0,
        'totalItems' => 0,
    ];
    protected $products = [];
    protected $isValidContent = true;

    public function isValidContent() : bool
    {
        return $this->isValidContent;
    }

    public function hasMorePages() : bool
    {
        return $this->pagination['page'] < $this->pagination['totalPages'];
    }

    public function getProducts() : array
    {
        return $this->products;
    }
}
