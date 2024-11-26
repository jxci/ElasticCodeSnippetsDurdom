<?php

namespace App\ElasticSearch;

class ElasticSearchClientFactory
{
    public static function create(ElasticSearchClientConfig $config)
    {
        return ClientBuilder::create()
            ->setHosts($config->getHosts())
            ->setRetries($config->getRetries())
            ->setConnectionParams([
                'timeout' => $config->getTimeout(),
                'verify' => $config->isSslVerificationEnabled(),
            ])
            ->build(); // Создание клиента
    }
}