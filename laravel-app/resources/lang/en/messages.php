<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Messages Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used for
    | The following language lines contain the default error messages used for
    | response message.
    |
    */
    'services' => [
        'errors' => [
            'delete' => 'Can\'t delete this service, there are doctors related with it'
        ],
        'success' => [
            'delete' => 'Service deleted successfully'
        ]
    ],
    'doctors' => [
        'success' => [
            'delete' => 'Doctor deleted successfully'
        ]
    ],
    'login' => [
        'errors' => [
            'wrong_data' => 'Wrong email or password',
            'token' => 'Token not provided',
            'authorization' => 'Not authorized',
            'user_not_found' => 'User not found',
        ]
    ]

];