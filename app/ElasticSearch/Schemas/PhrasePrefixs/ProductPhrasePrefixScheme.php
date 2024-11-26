<?php

namespace App\ElasticSearch\Schemas\PhrasePrefixs;

class ProductPhrasePrefixScheme
{
    /**
     * Возвращает все доступные схемы для фразового поиска по префиксу.
     * @return array
     */
    public static function all()
    {
        return [
            'match_phrase_prefix' => [
                'name' => 'debil',
            ],
        ];
    }

    /**
     * Возвращает запрос для фразового поиска с префиксом.
     *
     * @param string $field
     * @param string $value
     * @return array
     */
    public static function matchPhrasePrefix(string $field, string $value)
    {
        return [
            'match_phrase_prefix' => [
                $field => $value,
            ],
        ];
    }
}