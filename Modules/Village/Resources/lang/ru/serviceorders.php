<?php

return [
    'title' => [
        'model' => 'Заказ сервиса',
        'module' => 'Заказы сервисов',
        'create' => 'Создать заказ сервиса',
        'edit' => 'Редактировать заказ сервиса',
        'show' => 'Просмотр заказа продуктов',
    ],
    'button' => [
        'index' => 'Вернуться к списку',
        'edit' => 'Редактировать',
        'create' => 'Создать заказ сервиса',
        'status_running' => 'Начать выполнять',
        'status_done' => 'Выполнен',
        'status_paid_and_done' => 'Выполнен и оплачен'
    ],
    'table' => [
        'id' => 'ID заказа',
        'service' => 'Сервис',
        'perform_at' => 'Исполнить в',
        'address' => 'Адресс',
        'name' => 'ФИО',
        'phone' => 'Телефон',
        'price' => 'Цена',
        'payment_type' => 'Тип оплаты',
        'payment_status' => 'Статус оплаты',
        'status' => 'Статус',
        'user' => 'Пользователь',
        'comment' => 'Заметка покупателя',
        'decline_reason' => 'Причина отказа (от администратора)',
        'created_at' => 'Создан',
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
