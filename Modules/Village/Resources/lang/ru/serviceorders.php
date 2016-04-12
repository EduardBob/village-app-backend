<?php

return [
    'title' => [
        'model' => 'Заказ услуги',
        'module' => 'Заказы услуг',
        'create' => 'Создать заказ услуги',
        'edit' => 'Редактировать заказ услуги',
        'show' => 'Просмотр заказа услуг',
    ],
    'button' => [
        'index' => 'Вернуться к списку',
        'edit' => 'Редактировать',
        'create' => 'Создать заказ услуги',
        'status_running' => 'Начать выполнять',
        'status_done' => 'Выполнен',
        'status_paid_and_done' => 'Выполнен и оплачен'
    ],
    'table' => [
        'id' => 'ID заказа',
        'service' => 'Услуга',
        'perform_date' => 'На когда заказ',
        'perform_time' => 'Время исполнения',
        'address' => 'Адресс',
        'name' => 'ФИО',
        'phone' => 'Телефон',
        'unit_price' => 'Цена за ед.',
        'price' => 'Итого',
        'payment_type' => 'Тип оплаты',
        'payment_status' => 'Статус оплаты',
        'status' => 'Статус',
        'user' => 'Пользователь',
        'comment' => 'Заметка покупателя',
        'decline_reason' => 'Причина отказа (от администратора)',
        'created_at' => 'Создан',
        'done_at' => 'Выполнен',
        'phone' => 'Телефон',
        'admin_comment' => 'Заметка охранника',
        'actions' => 'Действия',
    ],
    'form' => [
        'service' => [
            'placeholder' => 'Не выбран'
        ],
        'user' => [
            'placeholder' => 'Не выбран'
        ],
        'payment' => [
            'type' => [
                'placeholder' => 'Не выбран',
                'values' => [
                    'cash' => 'Наличными',
                    'card' => 'Карточкой',
                ]
            ],
            'status' => [
                'placeholder' => 'Не выбран',
                'values' => [
                    'not_paid' => 'Не оплачен',
                    'paid'     => 'Оплачен',
                ]
            ],
        ],
        'status' => [
            'placeholder' => 'Не выбран',
            'values' => [
//                'not_paid' => 'Не оплачен',
                'processing' => 'Обрабатывается',
                'running' => 'Выполняется',
                'done' => 'Выполнен',
//                'canceled' => 'Отменён',
                'rejected' => 'Отклонён',
            ]
        ]
    ],
    'messages' => [
        'resource status-running' => 'Заказ выполняется',
        'resource status-done' => 'Заказ выполнен'
    ],
    'validation' => [
    ],
];
