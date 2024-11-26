<?php

namespace App\ElasticSearch;

class ElasticSearchEntityManager
{
    protected $client;

    public function __construct()
    {
        $configElasticArray = [];
        $elasticConfig = ElasticSearchClientConfigFactory::create($configElasticArray);
        $this->client = ElasticSearchClientFactory::create($elasticConfig);
    }

    public function search($elasticQueryBuilder, $options = [])
    {
        return $this->client->search(
            $elasticQueryBuilder->toQuery()
        );
    }
}