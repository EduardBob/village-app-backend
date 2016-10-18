<?php

return [
    'name' => 'Объекты',
    'title' => [
        'model' => 'Объект',
        'module' => 'Объекты',
        'create' => 'Добавить объект',
        'edit' => 'Редактировать объект',
    ],
    'button' => [
        'create' => 'Добавить объект',
        'add_phone' => 'Добавить телефон',
        'delete_phone' => 'Удалить телефон',
    ],
    'table' => [
        'id' => 'ID',
        'main_admin_id' => 'Главный администратор объекта',
        'name' => 'Название',
        'shop_name' => 'Название магазина',
        'shop_address' => 'Адрес магазина',
        'service_payment_info' => 'Информация об оплате для услуги',
        'service_bottom_text' => 'Информация об оплате для услуги (внизу)',
        'product_payment_info' => 'Информация об оплате для товара',
        'product_bottom_text' => 'Информация об оплате для товара (внизу)',
        'product_unit_step_kg' => 'Шаг изменения для киллограммов',
        'product_unit_step_bottle' => 'Шаг изменения для бутылок',
        'product_unit_step_piece' => 'Шаг изменения для штук',
        'send_sms_to_village_admin' => 'Отпрвлять SMS администратору объекта о новых заказах',
        'send_sms_to_executor' => 'Отпрвлять SMS исполнителю о новых заказах',
        'active' => 'Включен',
        'created_at' => 'Создана',
        'important_contacts' => 'Важная информация',
        'actions' => 'Действия',
    ],
    'form' => [
        'village_id' => 'Объект',
        'village' => [
            'placeholder' => 'Не выбран'
        ],
        'main_admin' => [
            'placeholder' => 'Не выбран',
            'help' => 'Получает sms при оплате заказа'
        ],
       'important_contacts' => [
           'label' => 'Контакт',
           'name' => 'Телефон'

        ]
    ],
    'messages' => [
    ],
    'validation' => [
    ],
    'emails' => [
        'request' => [
            'subject' => 'Новая заявка на подключение к системе «:site-name».',
            'title' => 'Новая заявка на подключение к системе «:site-name».',
            'full_name' => 'ФИО',
            'company_name' => 'Наименование организации',
            'phone' => 'Номер телефона',
            'position' => 'Контактное лицо',
            'positions' => [
                'admin' => 'Администратор',
                'chairman' => 'Председатель',
            ],
            'address' => 'Адрес',
        ],
        'partner_request' => [
            'subject' => 'Новая заявка на партнерство.',
            'title' => 'Новая заявка на партнерство.',
        ]
    ]
];
