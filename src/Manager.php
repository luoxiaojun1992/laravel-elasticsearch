<?php

namespace Lxj\Laravel\Elasticsearch;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

/**
 * Class Manager
 *
 * {@inheritdoc}
 *
 * ES连接管理
 *
 * @package Lxj\Laravel\Elasticsearch
 */
class Manager
{
    protected $connections;
    protected $config;

    public function __construct()
    {
        $this->config = config('elasticsearch');
    }

    /**
     * 获取ES连接
     *
     * @param  $connection_name
     * @return Client|null
     */
    public function connection($connection_name)
    {
        return $this->connections[$connection_name] ?? $this->addConnection($connection_name);
    }

    /**
     * 添加ES连接
     *
     * @param  $connection_name
     * @return Client|null
     */
    protected function addConnection($connection_name)
    {
        if (isset($this->connections[$connection_name])) {
            return $this->connections[$connection_name];
        }

        $connections_config = $this->config['connections'];
        if (isset($connections_config[$connection_name])) {
            return $this->connections[$connection_name] = ClientBuilder::fromConfig($connections_config[$connection_name]);
        }

        return null;
    }
}
