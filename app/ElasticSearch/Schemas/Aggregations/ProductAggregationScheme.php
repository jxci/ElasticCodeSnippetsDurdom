<?php

namespace App\ElasticSearch\Schemas\Aggregations;

class ProductAggregationScheme
{
    protected static $aggregations = [
        'category' => [
            'terms' => [
                'field' => 'category_id'
            ]
        ],
        'subcategory' => [
            'terms' => [
                'field' => 'subcategory_id'
            ]
        ],
        'price_range' => [
            'range' => [
                'field' => 'price',
                'ranges' => [
                    ['to' => 100],
                    ['from' => 100, 'to' => 500],
                    ['from' => 500]
                ]
            ]
        ],
    ];

    public static function get($name)
    {
        return self::$aggregations[$name] ?? null;
    }

    public static function all()
    {
        return self::$aggregations;
    }
}