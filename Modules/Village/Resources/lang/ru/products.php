<?php

return [
    'title' => [
        'model' => 'Товар',
        'module' => 'Товары',
        'create' => 'Создать товар',
        'edit' => 'Редактировать товар',
    ],
    'button' => [
        'create' => 'Создать товар',
    ],
    'table' => [
        'id' => 'ID',
        'title' => 'Название',
        'category' => 'Категория',
        'executor' => 'Исполнитель',
        'price' => 'Цена',
        'unit_title' => 'Ед. измерения',
        'comment_label' => 'Текст заметки',
        'text' => 'Описание',
        'active' => 'Доступен',
        'created_at' => 'Создан',
        'order' => 'Порядок',
        'has_card_payment' => 'Можно оплатить карточкой',
        'show_perform_time' => 'Возможность выбора удобного времени',
        'actions' => 'Действия',
        'show_all' => 'Будет видимым для других администраторов объектов',
    ],
    'form' => [
        'media' => 'Изображение',
        'category' => [
            'placeholder' => 'Не выбрана'
        ],
        'executor' => [
            'placeholder' => 'Не выбран'
        ],
        'unit_title' => [
            'placeholder' => 'Не выбрано',
            'values' => [
                'kg' => 'кг',
                'bottle' => 'бут.',
                'piece' => 'шт.',
            ]
        ]
    ],
    'messages' => [
    ],
    'validation' => [
    ],
];
