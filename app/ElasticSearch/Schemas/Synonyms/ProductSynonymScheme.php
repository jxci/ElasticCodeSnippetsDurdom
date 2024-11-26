<?php

namespace App\ElasticSearch\Schemas\Synonyms;

class ProductSynonymScheme
{
    protected static $synonyms = [
        'car' => ['automobile', 'vehicle'],
        'phone' => ['mobile', 'cellphone'],
    ];

    public static function get($term)
    {
        return self::$synonyms[$term] ?? [];
    }

    public static function all()
    {
        return self::$synonyms;
    }
}