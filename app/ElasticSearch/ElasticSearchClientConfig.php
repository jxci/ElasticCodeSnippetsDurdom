<?php

namespace App\ElasticSearch;

class ElasticSearchClientConfig
{
    protected $hosts;
    protected $retries;
    protected $timeout;
    protected $sslVerification;

    public function __construct()
    {
        $this->hosts = [env('ELASTICSEARCH_HOST')];
        $this->retries = 2;
        $this->timeout = 10;
        $this->sslVerification = false;
    }

    public function getHosts()
    {
        return $this->hosts;
    }

    public function getRetries()
    {
        return $this->retries;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    public function isSslVerificationEnabled()
    {
        return $this->sslVerification;
    }
}