<?php

namespace App\ElasticSearch\Schemas\Filters;

class ProductFilterScheme
{
    /**
     * Возвращает фильтр по категории продукта.
     *
     * @param int $categoryId
     * @return array
     */
    public static function categoryFilter(int $categoryId)
    {
        return [
            'term' => [
                'category_id' => $categoryId,
            ],
        ];
    }

    /**
     * Возвращает фильтр по диапазону цены.
     *
     * @param float|null $minPrice
     * @param float|null $maxPrice
     * @return array
     */
    public static function priceRangeFilter(float $minPrice = null, float $maxPrice = null)
    {
        $range = ['range' => ['price' => []]];
        if ($minPrice !== null) {
            $range['range']['price']['gte'] = $minPrice;
        }
        if ($maxPrice !== null) {
            $range['range']['price']['lte'] = $maxPrice;
        }
        return $range;
    }
}