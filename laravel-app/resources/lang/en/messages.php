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
            'delete' => 'Service deleted successfully',
            'created' => 'Service saved successfully',
            'updated' => 'Service updated successfully'

        ]
    ],
    'doctors' => [
        'success' => [
            'delete' => 'Doctor deleted successfully',
            'created' => 'Doctor saved successfully',
            'updated' => 'Doctor updated successfully'
        ],
        'errors' => [
            'date' => 'This date not available',
            'booking' => 'There is not times available in this date',
        ]
    ],
    'login' => [
        'errors' => [
            'wrong_data' => 'Wrong email or password',
            'token' => 'Token not provided',
            'authorization' => 'Not authorized',
            'user_not_found' => 'User not found',
        ]
    ],
    'booking' => [
        'success' => [
            'accept' => 'Booking successfully accepted',
            'cancel' => 'Booking successfully canceled',
            'created' => 'Booking saved successfully',
        ],
        'errors' => [
            'status' => 'Booking status can\'t  changed',
            'not_available' => 'Booking is not available at this time'
        ]
    ]

];