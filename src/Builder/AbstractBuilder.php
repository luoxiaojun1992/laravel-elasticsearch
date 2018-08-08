<?php

namespace Lxj\Laravel\Elasticsearch\Builder;

use Elasticsearch\Client;

class AbstractBuilder
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
