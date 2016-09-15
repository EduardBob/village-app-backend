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
        'send mass disabled' => 'Массовая отсылка sms выключена в целях безопастности. Попросите разработчиков включить её',
        'send on_order_processing disabled' => 'Отсылка sms, при переводе заказа в статус "Обрабатывается", выключена в целях безопастности. Попросите разработчиков включить её',
    ],
    'validation' => [
    ],
    'widget' => [
        'send' => [
            'village' => [
                'placeholder' => 'Все объекты',
            ],
            'title' => 'Отправить sms всем активным пользователям'
        ],
    ],
];
