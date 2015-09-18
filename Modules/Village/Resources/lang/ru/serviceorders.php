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
        'profile' => 'Пользователь',
        'decline_reason' => 'Причина отказа (от администратора)'
    ],
    'form' => [
        'service' => [
            'placeholder' => 'Не выбран'
        ],
        'profile' => [
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
