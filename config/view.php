<?php

return [
    'default' => env('VIEW_DRIVER', 'file'),
    'paths' => [
        resource_path('views'),
    ],
    'compiled' => env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views'))),
];
