<?php

return [
    'title' => [
        'model' => 'Заказ продуктов',
        'module' => 'Заказы продуктов',
        'create' => 'Создать заказ продуктов',
        'edit' => 'Редактировать заказ продуктов',
        'show' => 'Просмотр заказа продуктов',
    ],
    'button' => [
        'index' => 'Вернуться к списку',
        'edit' => 'Редактировать',
        'create' => 'Создать заказ продуктов',
        'status_running' => 'Начать выполнять',
        'status_done' => 'Выполнено',
    ],
    'table' => [
        'id' => 'ID заказа',
        'product' => 'Продукт',
        'quantity' => 'Кол-во',
        'unit_title' => 'Ед. измерения',
        'address' => 'Адрес',
        'perform_at' => 'Исполнить в',
        'price' => 'Цена',
        'user' => 'Пользователь',
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
        'status' => [
            'placeholder' => 'Не выбран',
            'values' => [
                'not_paid' => 'Не оплачен',
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
