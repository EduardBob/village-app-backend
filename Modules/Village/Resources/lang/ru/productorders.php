<?php

return [
    'title' => [
        'model' => 'Заказ товаров',
        'module' => 'Заказы товаров',
        'create' => 'Создать заказ товаров',
        'edit' => 'Редактировать заказ товаров',
        'show' => 'Просмотр заказа товаров',
    ],
    'button' => [
        'index' => 'Вернуться к списку',
        'edit' => 'Редактировать',
        'create' => 'Создать заказ товаров',
        'status_running' => 'Начать выполнять',
        'status_done' => 'Выполнен',
        'status_paid_and_done' => 'Выполнен и оплачен'
    ],
    'table' => [
        'id' => 'ID заказа',
        'product' => 'Товар',
        'quantity' => 'Кол-во',
        'unit_title' => 'Ед. измерения',
        'address' => 'Адрес',
        'perform_date' => 'Дата исполнения',
        'perform_time' => 'Время исполнения',
        'price' => 'Цена',
        'user' => 'Пользователь',
        'payment_type' => 'Тип оплаты',
        'payment_status' => 'Статус оплаты',
        'status' => 'Статус',
        'name' => 'ФИО',
        'phone' => 'Телефон',
        'comment' => 'Заметка покупателя',
        'decline_reason' => 'Причина отказа',
        'created_at' => 'Создан',
        'actions' => 'Действия',
    ],
    'form' => [
        'product' => [
            'placeholder' => 'Не выбран'
        ],
        'user' => [
            'placeholder' => 'Не выбран'
        ],
        'unit_title' => [
            'placeholder' => 'Не выбрано',
            'values' => [
                'kg' => 'кг',
                'bottle' => 'бут.',
                'piece' => 'шт.',
            ]
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
