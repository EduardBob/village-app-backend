<?php

return [
    'title' => [
        'model' => 'Заказ продуктов',
        'module' => 'Заказы продуктов',
        'create' => 'Создать заказ продуктов',
        'edit' => 'Редактировать заказ продуктов',
    ],
    'button' => [
        'create' => 'Создать заказ продуктов',
    ],
    'table' => [
        'id' => 'ID заказа',
        'product' => 'Продукт',
        'quantity' => 'Кол-во',
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
        'status' => [
            'placeholder' => 'Не выбран',
            'values' => [
                'processing' => 'Обрабатывается',
                'running' => 'Выполняется',
                'done' => 'Выполнен',
//                'canceled' => 'Отменён',
                'rejected' => 'Отклонён',
            ]
        ]
    ],
    'messages' => [
    ],
    'validation' => [
    ],
];
