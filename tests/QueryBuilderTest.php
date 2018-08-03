<?php

use Lxj\Laravel\Elasticsearch\QueryBuilder;
use Mockery as M;

class QueryBuilderTest extends \PHPUnit\Framework\TestCase
{
    public function testSearch()
    {
        $expected = [
            'hits' => [
                'hits' => [],
                'total' => 0,
            ]
        ];

        $client = M::mock(\Elasticsearch\Client::class);
        $client->shouldReceive('search')
            ->with([
                'index' => 'test_index',
                'type'  => 'test_type',
                'body'  => [
                    'query' => [
                        'match_all' => [],
                    ],
                ],
            ])
            ->andReturn($expected);

        $this->assertEquals(
            $expected,
            (new QueryBuilder($client))->index('test_index')
                ->type('test_type')
                ->matchAll()
                ->search()
        );
    }

    public function testCount()
    {
        $client = M::mock(\Elasticsearch\Client::class);
        $client->shouldReceive('search')
            ->with([
                'index' => 'test_index',
                'type'  => 'test_type',
                'from' => 0,
                'size' => 0,
                'body'  => [
                    'query' => [
                        'match_all' => [],
                    ],
                ],
            ])
            ->andReturn([
                'hits' => [
                    'hits' => [],
                    'total' => 0,
                ]
            ]);

        $this->assertEquals(
            0,
            (new QueryBuilder($client))->index('test_index')
                ->type('test_type')
                ->matchAll()
                ->count()
        );
    }

    public function tearDown()
    {
        parent::tearDown();

        M::close();
    }
}
