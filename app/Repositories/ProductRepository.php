<?php

namespace App\Repositories;

use App\Models\Product;
use DateTime;

class ProductRepository
{
    private static $sortingOptions = [
        'default' => 'title',
        'by_price_asc' => 'price'
    ];

    public function get(array $parameters = [])
    {
        $parameters = ProductRepository::defaultParameters($parameters);

        $builder = Product::where('title', 'like', '%'.$parameters['keywords'].'%')
            ->where('expiry_datetime', '>', (new DateTime('now'))->format('Y-m-d H:i:s'))
            ->orderBy($parameters['sorting']);

        if (isset($parameters['price_min']) && isset($parameters['price_max'])) {
            $builder->where('price', '>=', $parameters['price_min']);
            $builder->where('price', '<=', $parameters['price_max']);
        }

        return $builder->get();
    }

    public function updateOrCreateMany(array $products = [])
    {
        return Product::upsert($products, ['provider', 'item_id'], [
            'click_out_link',
            'main_photo_url',
            'price',
            'price_currency',
            'shipping_price',
            'title',
            'description',
            'valid_until',
            'brand',
            'expiry_datetime',
        ]);
    }

    private static function defaultParameters(array $parameters = [])
    {
        $sorting = $parameters['sorting'] ?? 'default';

        if (!in_array($sorting, array_keys(self::$sortingOptions))) {
            $sorting = 'default';
        }

        return [
            'keywords' => $parameters['keywords'],
            'price_min' => $parameters['price_min'] ?? null,
            'price_max' => $parameters['price_max'] ?? null,
            'sorting' => self::$sortingOptions[$sorting],
        ];
    }
}
