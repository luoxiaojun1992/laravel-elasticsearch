<?php

namespace Lxj\Laravel\Elasticsearch;

use Elasticsearch\Client;
use Illuminate\Support\Facades\Facade;

/**
 * Class Es
 *
 * @method  static Client connection(string $connection_name)
 * @package Lxj\Laravel\Elasticsearch
 */
class Es extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Manager::class;
    }
}
