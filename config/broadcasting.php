<?php

return [
    'default' => env('BROADCAST_CONNECTION', 'log'),
    'prefix' => env('BROADCAST_PREFIX', 'laravel_database'),
    'connections' => [
        'log' => [
            'driver' => 'log',
        ],
        'reverb' => [
            'driver' => 'reverb',
            'url' => env('REVERB_BROADCAST_URL', env('APP_URL')),
            'key' => env('REVERB_APP_KEY'),
            'secret' => env('REVERB_APP_SECRET'),
            'app_id' => env('REVERB_APP_ID'),
        ],
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ],
        ],
    ],
];
