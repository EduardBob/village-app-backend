<?php

return [
    'shop-name' => [
        'description' => 'Название магазина',
        'view' => 'text',
        'translatable' => false,
        'default' => '',
    ],
    'shop-address' => [
        'description' => 'Адрес магазина',
        'view' => 'text',
        'translatable' => false,
        'default' => '',
    ],
    'service-payment-info' => [
        'description' => 'Информация об оплате для сервиса',
        'view' => 'text',
        'translatable' => false,
        'default' => 'Произвести оплату вы сможете позже в своём профиле',
    ],
    'service-bottom-text' => [
        'description' => 'Информация об оплате для сервиса (внизу)',
        'view' => 'text',
        'translatable' => false,
        'default' => 'Ваша заявка будет принята и в кратчайшее время с Вами свяжется наш специалист. Просмотреть статус заявки, а также произвести оплату Вы сможете в своем профилее',
    ],
    'product-payment-info' => [
        'description' => 'Информация об оплате для продукта',
        'view' => 'text',
        'translatable' => false,
        'default' => 'оплата при самовывозе',
    ],
    'product-bottom-text' => [
        'description' => 'Информация об оплате для продукта (внизу)',
        'view' => 'text',
        'translatable' => false,
        'default' => 'Вы будете переадресованы на страницу оплаты. После успешной оплаты ваш заказ будет отправлен. Вы сможете увидеть его статус в своём профиле.',
    ],
    'product-unit-step-kg' => [
        'description' => 'Шаг изменения для киллограммов',
        'view' => 'text',
        'translatable' => false,
        'default' => '0.5',
    ],
    'product-unit-step-bottle' => [
        'description' => 'Шаг изменения для бутылок',
        'view' => 'text',
        'translatable' => false,
        'default' => '1',
    ],
    'product-unit-step-piece' => [
        'description' => 'Шаг изменения для штук',
        'view' => 'text',
        'translatable' => false,
        'default' => '1',
    ],
];
