<?php

namespace Lxj\Laravel\Elasticsearch\Builder;

use Lxj\Laravel\Elasticsearch\Es;

class BuilderFactory
{
    public static function createQueryBuilderFromConnection($connection)
    {
        return new QueryBuilder(self::createConnection($connection));
    }

    public static function createIndexBuilderFromConnection($connection)
    {
        return new IndexBuilder(self::createConnection($connection));
    }

    public static function createConnection($connection)
    {
        return Es::connection($connection);
    }
}
