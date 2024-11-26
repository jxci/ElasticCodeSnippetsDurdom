<?php

namespace App\ElasticSearch\Schemas\Phrases;

class ProductPhraseScheme
{
    /**
     * Возвращает все доступные схемы для фразового поиска.
     * @return array
     */
    public static function all()
    {
        return [
            'match_phrase' => [
                'category_id' => '4',
                'category_name' => 'phones',
            ],
        ];
    }

    /**
     * Возвращает запрос для фразового поиска.
     *
     * @param string $field
     * @param string $value
     * @return array
     */
    public static function matchPhrase(string $field, string $value)
    {
        return [
            'match_phrase' => [
                $field => $value,
            ],
        ];
    }

}
