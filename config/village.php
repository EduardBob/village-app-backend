<?php

return [
    'user' => [
        'phone' => [
            'mask' => '+7(999)999-99-99' # http://digitalbush.com/projects/masked-input-plugin/
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