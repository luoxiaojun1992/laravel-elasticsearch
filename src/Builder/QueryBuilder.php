<?php

namespace Lxj\Laravel\Elasticsearch\Builder;

/**
 * Class QueryBuilder
 *
 * {@inheritdoc}
 *
 * ES查询构造器
 *
 * @package Lxj\Laravel\Elasticsearch
 */
class QueryBuilder extends AbstractBuilder
{
    private $index;

    private $type;

    private $from;

    private $size;

    private $source = [];

    private $sort = [];

    private $query = [];

    private $id;

    private $scroll;

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

    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    public function size($size)
    {
        $this->size = $size;

        return $this;
    }

    public function source(array $source)
    {
        $this->source = array_merge($this->source, array_values($source));

        return $this;
    }

    public function sorts($sorts)
    {
        $this->sort = array_merge($this->sort, $sorts);

        return $this;
    }

    public function sort($field, $direction = 'asc')
    {
        $this->sort[] = [$field => $direction];

        return $this;
    }

    public function sortByDesc($field)
    {
        return $this->sort($field, 'desc');
    }

    public function bool()
    {
        $this->query['bool'] = [];

        return $this;
    }

    public function filter()
    {
        $this->query['bool']['filter'] = [];

        return $this;
    }

    public function filterByRule($rule_name, $rule)
    {
        $this->query['bool']['filter'][][$rule_name] = $rule;

        return $this;
    }

    public function filterRange($field, $operator, $value)
    {
        return $this->filterByRule('range', [
            $field => [$operator => $value]
        ]);
    }

    public function filterTerm($field, $value)
    {
        return $this->filterByRule('term', [
            $field => $value
        ]);
    }

    public function filterTerms($field, $values)
    {
        return $this->filterByRule('terms', [
            $field => array_values($values)
        ]);
    }

    public function where(array $conditions)
    {
        foreach ($conditions as $field => $value) {
            is_array($value) ? $this->filterTerms($field, $value) : $this->filterTerm($field, $value);
        }

        return $this;
    }

    public function filterGeoDistance($field, $distance, $location)
    {
        return $this->filterByRule('geo_distance', [
            'distance' => $distance,
            $field => $location,
        ]);
    }

    public function filterGeoPolygon($field, $points)
    {
        return $this->filterByRule('geo_polygon', [
            $field => ['points' => $points],
        ]);
    }

    public function filterGeoBoundingBox($field, $top_left, $bottom_right)
    {
        return $this->filterByRule('geo_bounding_box', [
            $field => ['top_left' => $top_left, 'bottom_right' => $bottom_right],
        ]);
    }

    public function must()
    {
        $this->query['bool']['must'] = [];

        return $this;
    }

    public function mustMatch($field, $value)
    {
        $this->query['bool']['must'][] = ['match' => [$field => $value]];

        return $this;
    }

    public function mustMatchPhrase($field, $value, ?\Closure $formatter = null)
    {
        $this->query['bool']['must'][] = [
            'match_phrase' => [$field => $formatter ? call_user_func($formatter, $value) : $value]
        ];

        return $this;
    }

    public function mustTerm($field, $value)
    {
        $this->query['bool']['must'][] = ['term' => [$field => $value]];

        return $this;
    }

    public function mustNot()
    {
        $this->query['bool']['must_not'] = [];

        return $this;
    }

    public function mustNotMatch($field, $value)
    {
        $this->query['bool']['must_not'][] = ['match' => [$field => $value]];

        return $this;
    }

    public function mustNotMatchPhrase($field, $value)
    {
        $this->query['bool']['must_not'][] = ['match_phrase' => [$field => $value]];

        return $this;
    }

    public function mustNotTerm($field, $value)
    {
        $this->query['bool']['must_not'][] = ['term' => [$field => $value]];

        return $this;
    }

    public function should()
    {
        $this->query['bool']['should'] = [];

        return $this;
    }

    public function shouldMatch($field, $value)
    {
        $this->query['bool']['should'][] = ['match' => [$field => $value]];

        return $this;
    }

    public function shouldMatchPhrase($field, $value)
    {
        $this->query['bool']['should'][] = ['match_phrase' => [$field => $value]];

        return $this;
    }

    public function shouldTerm($field, $value)
    {
        $this->query['bool']['should'][] = ['term' => [$field => $value]];

        return $this;
    }

    public function matchAll()
    {
        $this->query['match_all'] = [];

        return $this;
    }

    public function id($id)
    {
        $this->id = $id;

        return $this;
    }

    public function count()
    {
        return $this->from(0)->size(0)->search()['hits']['total'];
    }

    public function build()
    {
        $params = [
            'index' => $this->index,
            'type'  => $this->type,
        ];

        if ($this->query) {
            $params['body']['query'] = $this->query;
        }

        if (!is_null($this->from)) {
            $params['from'] = $this->from;
        }
        if (!is_null($this->size)) {
            $params['size'] = $this->size;
        }
        if (count($this->source) > 0) {
            $params['body']['_source'] = $this->source;
        }
        if (count($this->sort) > 0) {
            $params['body']['sort'] = $this->sort;
        }
        if (!is_null($this->id)) {
            $params['id'] = $this->id;
        }
        if (!is_null($this->scroll)) {
            $params['scroll'] = $this->scroll;
        }

        return $params;
    }

    public function search()
    {
        return $this->client->search($this->build());
    }

    public function get()
    {
        return $this->client->get($this->build());
    }

    public function scroll($scroll_id, $scroll)
    {
        return $this->client->scroll(compact('scroll_id', 'scroll'));
    }
}
