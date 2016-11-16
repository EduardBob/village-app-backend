<?php

return [
  'name'   => 'Объекты',
  'title'  => [
    'model'  => 'Объект',
    'module' => 'Объекты',
    'create' => 'Добавить объект',
    'edit'   => 'Редактировать объект',
  ],
  'button' => [
    'create'       => 'Добавить объект',
    'add_phone'    => 'Добавить телефон',
    'delete_phone' => 'Удалить телефон',
  ],
  'type'   => [
    'business'  => 'Бизнес-Центр',
    'shopping'  => 'Торговый Центр',
    'cottage'   => 'Коттеджный Посёлок',
    'apartment' => 'Жилой Комплекс',
  ],

  'packet' => [
    'chose'               => 'Выбор пакета',
    'current'             => 'Текущий пакет',
    'balance'             => 'Баланс',
    'active_to'           => 'активен до',
    'money'               => 'монет',
    'not_active'          => 'не активен',
    'buildings'           => 'Количество домов',
    'price'               => 'Цена',
    'add_balance_title'   => 'Пополнить счет',
    'coins_per_month'     => 'Стоимость пакета',
    'add_balance'         => 'Пополнить',
    'left_buildings'      => 'Осталось неподключенных домов',
    'current'             => 'Текущий',
    'move_to_packet'      => 'Перейти на этот пакет',
    'chose_error'         => 'Выбран некорректный пакет ',
    'switched_to'         => 'Ваш пакет был переключен на',
    'balance_refill_left' => ' на пополнение счета у Вас есть завтрашний день.',
    'balance_tomorrow'    => ' средсва со счета спишутся завтра.',
    'months'              => '{1} месяц|[2, 4]месяца|[5, 11] месяцов',
    'days'              => '{1}1 день|[2, 4]:count дня|[5, 11]:count дней',
    'years'              => '{1} на :count год|[2, 4] на :count года |[5, Inf] на :count лет',
    'and_get_50_off' => ' и получить дополнительно 50% монет',
    'chose_period' => 'Выберите период пополнения',
    'bonus_coins' => 'бонусных монет',
    'rub' => 'руб',
    'total' => 'Итого к оплате',
    'total_coins' => 'Будет зачисленно',
    'and_get_more' => 'и получить дополнительно :count% монет',
    'for' => 'на',
    'today' => 'сегодня'
  ],

  'table'      => [
    'id'                        => 'ID',
    'main_admin_id'             => 'Главный администратор объекта',
    'name'                      => 'Название',
    'shop_name'                 => 'Название магазина',
    'shop_address'              => 'Адрес магазина',
    'service_payment_info'      => 'Информация об оплате для услуги',
    'service_bottom_text'       => 'Информация об оплате для услуги (внизу)',
    'product_payment_info'      => 'Информация об оплате для товара',
    'product_bottom_text'       => 'Информация об оплате для товара (внизу)',
    'product_unit_step_kg'      => 'Шаг изменения для киллограммов',
    'product_unit_step_bottle'  => 'Шаг изменения для бутылок',
    'product_unit_step_piece'   => 'Шаг изменения для штук',
    'send_sms_to_village_admin' => 'Отпрвлять SMS администратору объекта о новых заказах',
    'send_sms_to_executor'      => 'Отпрвлять SMS исполнителю о новых заказах',
    'active'                    => 'Включен',
    'created_at'                => 'Создана',
    'important_contacts'        => 'Важная информация',
    'actions'                   => 'Действия',
    'payed_until'               => 'Оплачено до',
    'packet'                    => 'Действующий пакет',
    'balance'                   => 'Баланс (монет)'
  ],
  'services'   => [
    'create_in'           => 'Привязать к объектам (создаются в объекте при регистрации):',
    'currency_conversion' => 'Стоимость 1000 рублей в монетах'
  ],
  'form'       => [
    'village_id'         => 'Объект',
    'village'            => [
      'placeholder' => 'Не выбран'
    ],
    'main_admin'         => [
      'placeholder' => 'Не выбран',
      'help'        => 'Получает sms при оплате заказа'
    ],
    'important_contacts' => [
      'label' => 'Контакт',
      'name'  => 'Телефон'
    ]
  ],
  'messages'   => [
    'created'         => 'Заявка принята, <a href="#" data-popup-link="confirm">поддтвердите</a> номер телефона кодом доступа высланным по SMS и на Email.',
    'confirmed'       => 'Регестрация подтверждена.',
    'user_not_found'  => 'Неверный номер телефона или код подтверждения.',
    'token_not_found' => 'Неверный номер телефона или код подтверждения.'
  ],
  'validation' => [
  ],
  'emails'     => [
    'request'         => [
      'subject'      => 'Новая заявка на подключение к системе «:site-name».',
      'title'        => 'Новая заявка на подключение к системе «:site-name».',
      'full_name'    => 'ФИО',
      'company_name' => 'Наименование организации',
      'phone'        => 'Номер телефона',
      'position'     => 'Контактное лицо',
      'positions'    => [
        'admin'    => 'Администратор',
        'chairman' => 'Председатель',
      ],
      'address'      => 'Адрес',
    ],
    'partner_request' => [
      'subject' => 'Новая заявка на партнерство.',
      'title'   => 'Новая заявка на партнерство.',
    ]
  ]
];
