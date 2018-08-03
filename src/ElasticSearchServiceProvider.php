<?php

namespace Lxj\Laravel\Elasticsearch;

use Illuminate\Support\ServiceProvider;

class ElasticSearchServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            Manager::class, function () {
            return new Manager();
        }
        );
    }
}
