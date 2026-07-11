<?php

return [
    'driver' => env('FORTIFY_GUARD', 'web'),
    'middleware' => [
        'web' => true,
        'api' => false,
    ],
];
