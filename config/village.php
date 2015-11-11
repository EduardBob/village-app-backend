<?php

return [
    'token' => [
        'code' => [
            'min' => env('VILLAGE_TOKEN_CODE_MIN', 10000),
            'max' => env('VILLAGE_TOKEN_CODE_MAX', 99999),
        ],
        'session' => [
            /**
             * Don't change without new migration with changing max length of this field
             */
            'length' => env('VILLAGE_TOKEN_SESSION_LENGTH', 10),
        ]
    ],
    'sms' => [
        'username' => env('VILLAGE_SMS_USERNAME'),
        'password' => env('VILLAGE_SMS_PASSWORD'),
        'enabled'  => [
            'mass'                => env('VILLAGE_SMS_MASS_SEND_ENABLED', false),
            'on_order_processing' => env('VILLAGE_SMS_SEND_ON_ORDER_PROCESSING', false),
        ],
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
    'product' => [
        'comment' => [
            'label' => 'Ваши пожелания и заметки'
        ],
        'unit' => [
            'values' => ['kg', 'bottle', 'piece']
        ],
    ],
    'service' => [
        'comment' => [
            'label' => 'Ваши пожелания и заметки'
        ],
        'order_button' => [
            'label' => 'Заказать'
        ]
    ],
    'order' => [
        'first_status' => 'not_paid',
        'statuses' => ['not_paid', 'processing', 'running', 'done', 'rejected'], // cancelled
        'label' => [
            'not_paid' => 'info', //Обрабатывается
            'processing' => 'primary', //Обрабатывается
            'running' => 'waring', // Выполняется
            'done' => 'success', //Выполнен
            'rejected' => 'danger', // Отклонён
//            'paid' =>  'primary',
//            'cancelled' =>  'danger'
        ]
    ],
    'date' => [
        'format' => 'Y-m-d H:i',
        'human' => [
            'short' => 'd M Y',
            'medium' => 'd M Y H:i',
            'standard' => 'd M Y H:i:s',
        ]
    ],
];