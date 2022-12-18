<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'salesremainder' => [
        'year' => env('FISCAL_YEAR'),
        'bonuscutofdate' => env('BONUS_CUT_OF_DATE'),
        'weekdays' => [
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thursday' => 4,
            'Friday' => 5,
        ],
        'weekends' => [
            'Saturday' => 6,
            'Sunday' => 7
        ],
        'listmonths' => [
            [
                'month' => "January",
                'number' => 1,
            ],
            [
                'month' => "February",
                'number' => 2,
            ],
            [
                'month' => "March",
                'number' => 3,
            ],
            [
                'month' => "April",
                'number' => 4,
            ],
            [
                'month' => "May",
                'number' => 5,
            ],
            [
                'month' => "June",
                'number' => 6,
            ],
            [
                'month' => "July",
                'number' => 7,
            ],
            [
                'month' => "August",
                'number' => 8,
            ],
            [
                'month' => "September",
                'number' => 9,
            ],
            [
                'month' => "October",
                'number' => 10,
            ],
            [
                'month' => "November",
                'number' => 11,
            ],
            [
                'month' => "December",
                'number' => 12,
            ]

            ],
        'storage_paths' => [
            'path' => 'files/'
        ],
        'questions' => [
            'reenterdate' => env('QUESTION_WRONG_DATE'),
            'filename' => env('QUESTION_FILE_NAME'),
        ]

    ],



];
