<?php

return [
    'connections' => [
        'default' => [
            'hosts' => [
                env('ES_SERVER', ''),
            ],
        ],
    ],
];
