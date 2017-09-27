<?php
/**
 * Created by PhpStorm.
 * User: diogosilva
 * Date: 27/09/2017
 * Time: 00:44
 */

return [
    'defaults' => [
        'guard'     => 'api',
        'passwords' => 'users',
    ],

    'guards' => [
        'api' => [
            'driver'   => 'passport',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => \App\User::class,
        ],
    ],
];