<?php

return [

    'ugc' => [
        'driver' => 'local',
        'root' => public_path(),
        'url' => env('APP_URL'),
        'visibility' => 'public',
    ],
    'modules' => [
        'driver' => 'local',
        'root' => base_path('modules'),
        'visibility' => 'public'
    ],

    'core' => [
        'driver' => 'local',
        'root' => base_path('app/Core'),
        'visibility' => 'public'
    ],

];
