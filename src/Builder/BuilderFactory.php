<?php

namespace Lxj\Laravel\Elasticsearch\Builder;

use Lxj\Laravel\Elasticsearch\Es;

class BuilderFactory
{
    public static function createQueryBuilder()
    {
        return self::createQueryBuilderFromConnection();
    }

    public static function createIndexBuilder()
    {
        return self::createIndexBuilderFromConnection();
    }

    public static function createQueryBuilderFromConnection($connection = 'default')
    {
        return new QueryBuilder(self::createConnection($connection));
    }

    public static function createIndexBuilderFromConnection($connection = 'default')
    {
        return new IndexBuilder(self::createConnection($connection));
    }

    public static function createConnection($connection = 'default')
    {
        return Es::connection($connection);
    }
}
