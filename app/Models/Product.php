<?php

namespace App\Models;

use App\ElasticSearch\Schemas\Aggregations\ProductAggregationScheme;
use App\ElasticSearch\Schemas\Synonyms\ProductSynonymScheme;

class Product extends Model
{
    protected static $index = 'products';
    protected static $fields = ['name', 'category', 'subcategory'];
    protected static $boost = [
        'name' => 2.0,
        'category' => 1.0,
        'subcategory' => 1.0,
    ];

    protected static $fuzziness = 'AUTO';

    public static function getIndex() { return self::$index; }
    public static function getFields() { return self::$fields; }
    public static function getBoost() { return self::$boost; }
    public static function getFuzziness() { return self::$fuzziness; }

    public static function getAggregations()
    {
        return ProductAggregationScheme::all();
    }

    public static function getSynonyms($term)
    {
        return ProductSynonymScheme::get($term);
    }
}