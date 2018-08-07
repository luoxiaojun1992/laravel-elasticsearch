<?php

namespace Lxj\Laravel\Elasticsearch;

use Elasticsearch\Client;

/**
 * Class IndexBuilder
 *
 * {@inheritdoc}
 *
 * ES索引构造器
 *
 * @package Lxj\Laravel\Elasticsearch
 */
class IndexBuilder
{
    private $client;

    private $index;

    private $type;

    private $id;

    private $fields = [];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index($index)
    {
        $this->index = $index;

        return $this;
    }

    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    public function id($id)
    {
        $this->id = $id;

        return $this;
    }

    public function fields(array $fields)
    {
        $this->fields = array_merge($this->fields, $fields);

        return $this;
    }

    public function addField($field, $value)
    {
        $this->fields[$field] = $value;

        return $this;
    }

    private function build()
    {
        $params = [
            'index' => $this->index,
        ];

        if (!is_null($this->type)) {
            $params['type'] = $this->type;
        }
        if (!is_null($this->id)) {
            $params['id'] = $this->id;
        }
        if (count($this->fields) > 0) {
            $params['body'] = $this->fields;
        }

        return $params;
    }

    public function addDoc()
    {
        return $this->client->index($this->build());
    }

    public function deleteDoc()
    {
        return $this->client->delete($this->build());
    }

    public function createIndex()
    {
        return $this->client->indices()->create($this->build());
    }

    public function deleteIndex()
    {
        return $this->client->indices()->delete($this->build());
    }
}
