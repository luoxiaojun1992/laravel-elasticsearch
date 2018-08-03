<?php

use Monolog\Logger;

return [
    'connections' => [
        'default' => [
            'hosts' => [
                env('ES_SERVER', ''),
            ],
            'logPath' => env('ES_LOG_PATH', ''),
            'logLevel' => env('ES_LOG_LEVEL', Logger::INFO),
        ],
    ],
];
