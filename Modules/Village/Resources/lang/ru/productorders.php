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
        'payment_done' => 'Оплачен',
        'status_paid_and_done' => 'Выполнен и оплачен'
    ],
    'table' => [
        'id' => 'ID заказа',
        'product' => 'Товар',
        'quantity' => 'Кол-во',
        'unit_price' => 'Цена за ед.',
        'unit_title' => 'Ед. измерения',
        'address' => 'Адрес',
        'perform_date' => 'На когда заказ',
        'perform_time' => 'Время исполнения',
        'price' => 'Итого',
        'user' => 'Пользователь',
        'payment_type' => 'Тип оплаты',
        'payment_status' => 'Статус оплаты',
        'status' => 'Статус',
        'name' => 'ФИО',
        'phone' => 'Телефон',
        'comment' => 'Заметка',
        'decline_reason' => 'Причина отказа',
        'created_at' => 'Создан',
        'done_at' => 'Выполнен',
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
        'resource status-done' => 'Заказ выполнен',
        'resource payment-done' => 'Заказ оплачен',
	    'resource payment-and-status-done' => 'Заказ оплачен и выполнен',
    ],
    'validation' => [
    ],
];
