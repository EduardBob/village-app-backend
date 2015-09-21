<?php

return [
    'title' => [
        'model' => 'Заказ сервиса',
        'module' => 'Заказы сервисов',
        'create' => 'Создать заказ сервиса',
        'edit' => 'Редактировать заказ сервиса',
    ],
    'button' => [
        'create' => 'Создать заказ сервиса',
    ],
    'table' => [
        'id' => 'ID заказа',
        'service' => 'Сервис',
        'perform_at' => 'Perform at',
        'address' => 'Адресс',
        'name' => 'ФИО',
        'phone' => 'Телефон',
        'price' => 'Цена',
        'status' => 'Статус',
        'user' => 'Пользователь',
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
        'status' => [
            'placeholder' => 'Не выбран',
            'values' => [
                'in_progress' => 'Обрабатывается',
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
