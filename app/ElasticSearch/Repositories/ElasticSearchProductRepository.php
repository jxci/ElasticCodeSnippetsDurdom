<?php

namespace App\ElasticSearch\Repositories;

use ElasticSearch\ElasticSearchEntityManager;
use ElasticSearch\ElasticSearchQueryBuilder;
use models\Product;

class ElasticSearchProductRepository
{
    protected $elasticSearchManager;

    public function __construct(ElasticSearchEntityManager $elasticSearchManager)
    {
        $this->elasticSearchManager = $elasticSearchManager;
    }

    public function search(string $queryString)
    {
        $options = [];

        // Создаем новый экземпляр Query Builder с индексом продукта
        $queryBuilder = new ElasticSearchQueryBuilder(Product::getIndex());

        // Получаем синонимы для запроса
        $synonyms = Product::getSynonyms($queryString);

        // Используем оригинальный запрос и его синонимы
        $termsToSearch = array_merge([$query], $synonyms);

        // Добавление условий поиска
        foreach (Product::getFields() as $field) {
            foreach ($termsToSearch as $term) {
                $queryBuilder->addMatch($field, $term, Product::getBoost()[$field] ?? 1.0);

                if (!empty($options['use_phrase'])) {
                    $queryBuilder->addPhrase($field, $term);
                }

                if (!empty($options['use_phrase_prefix'])) {
                    $queryBuilder->addPhrasePrefix($field, $term);
                }
            }
        }

        // Добавление фильтров, если указаны
        if (!empty($options['filters'])) {
            foreach ($options['filters'] as $filter) {
                $queryBuilder->addFilter($filter);
            }
        }

        // Добавление функции оценки (FSQ), если указано
        if (!empty($options['function_score'])) {
            $queryBuilder->addFunctionScore($options['function_score']);
        }

        // Добавление агрегаций к запросу
        foreach (Product::getAggregations() as $name => $aggregation) {
            $queryBuilder->addAggregation($name, $aggregation);
        }

        // Выполняем поиск с уже готовым Query Builder
        return $this->elasticSearchManager->search($queryBuilder);
    }
}