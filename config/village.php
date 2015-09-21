<?php

return [
    'token' => [
        'code' => [
            'min' => env('VILLAGE_TOKEN_CODE_MIN', 1000000),
            'max' => env('VILLAGE_TOKEN_CODE_MAX', 9999999),
        ],
        'session' => [
            /**
             * Don't change without new migration with changing max length of this field
             */
            'length' => env('VILLAGE_TOKEN_SESSION_LENGTH', 10),
        ]
    ],
    'user' => [
        'phone' => [
            /**
             * @link http://digitalbush.com/projects/masked-input-plugin/
             */
            'mask' => env('VILLAGE_USER_PHONE_MASK', '+7(999)9999999'),
            /**
             * Validates Russian Phone Number
             * Pass: +7(916)9985670
             * @link http://www.etl-tools.com/regular-expressions/is-russian-phone-number.html
             * Laravel note: When using the regex pattern, it may be necessary to specify rules in an array instead of using pipe delimiters,
             *       especially if the regular expression contains a pipe character.
             */
            'regex' => env('VILLAGE_USER_PHONE_REGEX', '/^\+7\(\d{3}\)\d{7}$/'),
        ]
    ],
    'order' => [
        'statuses' => ['in_progress', 'done', 'rejected'], // cancelled
        'label' => [
            'in_progress' => 'primary',
            'done' => 'success',
            'rejected' => 'danger',
//            'paid' =>  'primary',
//            'cancelled' =>  'danger'
        ]
    ],
    'date' => [
        'format' => 'Y-m-d H:i'
    ]
];