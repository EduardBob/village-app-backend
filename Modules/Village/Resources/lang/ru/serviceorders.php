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
        'status_done' => 'Выполнено'
    ],
    'table' => [
        'id' => 'ID заказа',
        'service' => 'Сервис',
        'perform_at' => 'Исполнить в',
        'address' => 'Адресс',
        'name' => 'ФИО',
        'phone' => 'Телефон',
        'price' => 'Цена',
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
