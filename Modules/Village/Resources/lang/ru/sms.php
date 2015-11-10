<?php

return [
    'title' => [
        'model' => 'Sms',
        'module' => 'Sms',
        'create' => 'Добавить sms',
        'edit' => 'Редактировать sms',
    ],
    'button' => [
        'create' => 'Добавить sms',
    ],
    'table' => [
        'id' => 'ID',
        'text' => 'Текст',
        'created_at' => 'Создана',
        'actions' => 'Действия',
    ],
    'messages' => [
        'sent all' => 'Sms отосланы. Всего: :total. Успешных :success. Неудачных: :error',
        'sent validation error' => 'Укажите текст sms сообщения',
        'sent no one' => 'Нет пользователей по указанным критериям',
    ],
    'validation' => [
    ],
    'widget' => [
        'send' => [
            'village' => [
                'placeholder' => 'Все посёлки',
            ],
            'title' => 'Отправить sms всем пользователям посёлка'
        ],
    ],
];
