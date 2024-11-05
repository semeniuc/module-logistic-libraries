<?php

/**
 * Default access settings
 * d - disable
 * u - edit
 * r - read
 * w - full
 */
return [
    'dev' => [
        'all' => 'd',
        'user_1' => 'w',
        'user_24' => 'w',
    ],
    'prod' => [
        'all' => 'd',
        'user_1' => 'w',
        'user_20' => 'w',
    ],
];