<?php

return [
    'name' => 'Посёлки',
    'title' => [
        'model' => 'Посёлок',
        'module' => 'Посёлки',
        'create' => 'Добавить посёлок',
        'edit' => 'Редактировать посёлок',
    ],
    'button' => [
        'create' => 'Добавить посёлок',
    ],
    'table' => [
        'id' => 'ID',
        'main_admin_id' => 'Главный администратор посёлка',
        'name' => 'Название',
        'shop_name' => 'Название магазина',
        'shop_address' => 'Адрес магазина',
        'service_payment_info' => 'Информация об оплате для сервиса',
        'service_bottom_text' => 'Информация об оплате для сервиса (внизу)',
        'product_payment_info' => 'Информация об оплате для продукта',
        'product_bottom_text' => 'Информация об оплате для продукта (внизу)',
        'product_unit_step_kg' => 'Шаг изменения для киллограммов',
        'product_unit_step_bottle' => 'Шаг изменения для бутылок',
        'product_unit_step_piece' => 'Шаг изменения для штук',
        'active' => 'Включен',
        'created_at' => 'Создана',
        'actions' => 'Действия',
    ],
    'form' => [
        'village_id' => 'Поселок',
        'village' => [
            'placeholder' => 'Не выбран'
        ],
        'main_admin' => [
            'placeholder' => 'Не выбран',
            'help' => 'Получает sms при оплате заказа'
        ]
    ],
    'messages' => [
    ],
    'validation' => [
    ],
    'emails' => [
        'request' => [
            'subject' => 'Новая заявка на партнёрство с сайта :site-name',
            'title' => 'Новая заявка на партнёрство',
            'full_name' => 'ФИО',
            'phone' => 'Номер телефона',
            'position' => 'Должность',
            'positions' => [
                'admin' => 'Администратор',
                'chairman' => 'Председатель',
            ],
            'address' => 'Адрес',
        ]
    ]
];
