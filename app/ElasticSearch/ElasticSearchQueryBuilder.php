<?php

namespace App\ElasticSearch;

class ElasticSearchQueryBuilder
{
    protected $index;
    protected $query;

    public function __construct($index)
    {
        $this->index = $index;
        $this->query = [
            'bool' => [
                'should' => []
            ]
        ];
    }
    public function match($field, $value, $boost = 1.0)
    {
        $this->query['bool']['should'][] = [
            'match' => [
                $field => [
                    'query' => $value,
                    'fuzziness' => Product::getFuzziness(),
                    'boost' => $boost
                ]
            ]
        ];
        return $this;
    }

    public function pharse($field, $value)
    {
        $this->query['bool']['should'][] = [
            'match_phrase' => [
                $field => [
                    'query' => $value,
                    'boost' => 1.0
                ]
            ]
        ];
        return $this;
    }

    public function pharsePrefix($field, $value)
    {
        $this->query['bool']['should'][] = [
            'match_phrase_prefix' => [
                $field => [
                    'query' => $value,
                    'boost' => 1.0
                ]
            ]
        ];
        return $this;
    }

    public function filter($filter)
    {
        if (!isset($this->query['bool']['filter'])) {
            $this->query['bool']['filter'] = [];
        }

        if (is_array($filter)) {
            // Если фильтр является массивом (например, ['term' => ['status' => 'active']])
            array_push($this->query['bool']['filter'], ...$filter);
        } else {
            array_push($this->query['bool']['filter'], [$filter]);
        }

        return $this;
    }

    public function score($functionScore)
    {
        // Добавляем функцию оценки к запросу
        if (!isset($this->query['function_score'])) {
            // Оборачиваем текущий запрос в FSQ
            $currentQuery = ['bool' => ['should' => array_merge([], ...array_values($this->query['bool']['should']))]];

            // Заменяем текущий запрос на FSQ
            unset($this->query['bool']);

            // Создаем новый запрос с функцией оценки
            $this->query = [
                'function_score' => [
                    'query' =>  $currentQuery,
                    'functions' => [$functionScore],
                    'boost_mode' => 'multiply',
                ]
            ];

            return;
        }

        if (isset($this->query['function_score']['functions'])) {
            array_push($this->query['function_score']['functions'], ...$functionScore);
        }

        return;
    }

    public function toQuery()
    {
        return [
            'index' => $this->index,
            'body' => [
                'query' => $this->query
            ]
        ];
    }
}