<?php

return [
    'connections' => [
        'default' => [
            'hosts' => [
                env('ES_SERVER', ''),
            ],
            'logPath' => storage_path('logs/es.log'),
            'logLevel' => \Monolog\Logger::WARNING,
        ],
    ],
];
