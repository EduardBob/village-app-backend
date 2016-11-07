<?php

return [
    'table' => [
        'phone' => 'Телефон',
        'building_id' => 'Адрес',
        'activated' => 'Активирован',
        'has_mail_notifications' => 'Уведомлять по Email',
        'has_sms_notifications' => 'Уведомлять по SMS',
    ],
    'messages' => [
      'reset_code_sent'     => 'Код подтверждения смены пароля выслан по SMS. <a href="#" data-popup-link="change-password">Сменить пароль</a>',
      'phone_not_found'     => 'Неверный номер телефона.',
      'phone_not_activated' => 'Данный номер телефона неактивен.',
      'password_changed' => 'Ваш пароль был изменен',
      'code_not_found' => 'Неверный код.',

    ],
    'form' => [
        'phone' => 'Телефон',
        'additional_villages' => 'Дополнительные объекты',
        'additional_villages_info' => 'Редактирование поля доступно глобальным администраторам, только для пользователей роли "Исполнитель"',
        'cancel_selection' => 'Отменить выбор',
        'building_id' => 'Адрес',
        'building' => [
            'placeholder' => 'Не указан'
        ],
        'has_mail_notifications' => 'Email уведомления',
        'has_sms_notifications'  => 'SMS',
    ],
];
