<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'staff_users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'staff_users',  // デフォルトはスタッフ
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admin_users',
        ],
        'staff' => [
            'driver' => 'session',
            'provider' => 'staff_users',
        ],
    ],

    'providers' => [
        'admin_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\AdminUser::class,
        ],
        'staff_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\StaffUser::class,
        ],
    ],

    'passwords' => [
        'staff_users' => [
            'provider' => 'staff_users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'admin_users' => [
            'provider' => 'admin_users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];