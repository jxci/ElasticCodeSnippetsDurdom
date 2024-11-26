<?php

namespace App\ElasticSearch;

class ElasticSearchClientConfigFactory
{
    public static function create(array $data) : ElasticSearchClientConfig
    {
        return new ElasticSearchClientConfig();
    }
}