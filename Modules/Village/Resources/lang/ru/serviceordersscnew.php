<?php

return [
    'title' => [
        'model' => 'Журнал проезда (3 дня)',
        'module' => 'Журнал проезда (3 дня)',
        'show' => 'Просмотр',
        'create' => 'Создать'
    ],
    'button' => [
        'index' => 'Вернуться к списку',
        'edit' => 'Редактировать',
        'create' => 'Создать заказ услуги',
        'status_running' => 'Начать выполнять',
        'status_done' => 'Выполнен',
        'status_done_and_open_door' => 'Выполнить и открыть калитку',
        'status_done_and_open_barrier' => 'Выполнить и открыть шлагбаум',
    ],
    'table' => [
        'id' => 'ID заказа',
        'service' => 'Услуга',
        'perform_date' => 'На когда заказ',
        'perform_time' => 'Время исполнения',
        'address' => 'Адрес',
        'name' => 'ФИО',
        'phone' => 'Телефон',
        'unit_price' => 'Цена за ед.',
        'price' => 'Итого',
        'payment_type' => 'Тип оплаты',
        'payment_status' => 'Статус оплаты',
        'status' => 'Статус',
        'user' => 'Пользователь',
        'comment' => 'Заметка',
        'decline_reason' => 'Причина отказа (от администратора)',
        'created_at' => 'Создан',
        'done_at' => 'Выполнен',
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
        'resource status-done-and-door-was-opened' => 'Заказ выполнен и калитка открыта',
        'resource status-done-and-barrier-was-opened' => 'Заказ выполнен и шлагбаум открыт',
    ],
];
