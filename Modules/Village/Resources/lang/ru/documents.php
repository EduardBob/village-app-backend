<?php

return [
  'title'      => [
    'model'  => 'Документ',
    'module' => 'Документы',
    'create' => 'Добавить документ',
    'edit'   => 'Редактировать документ',
  ],
  'button'     => [
    'create' => 'Добавить документ',
  ],
  'table'      => [
    'id'           => 'ID',
    'title'        => 'Название',
    'text'         => 'Текст',
    'active'       => 'Включен',
    'created_at'   => 'Создан',
    'actions'      => 'Действия',
    'type'         => 'Тип',
    'published_at' => 'Опубликован',
    'village_id'   => 'Для всех объектов',
    'is_important' => 'Важный',
    'category_id' => 'Категория',
    'is_personal'  => 'Персональный',
    'role_id'      => 'Роль',
    'is_protected' => 'Скрыт от всех кроме глобальных администраторов',
    'type' => 'Тип документа',
    'types' => [
      'invoice'     => 'Cчета',
      'application' => 'Заявлнения',
      'reference'   => 'Справки',
      'other' => 'Прочие',
    ]
  ],
  'form'       => [
    'media'        => 'Файл',
    'users'        => 'Пользователи',
    'all_roles'    => 'Все роли',
    'to_all_users' => 'Всем пользователям',
    'no_users'     => 'Нет пользователей',
    'text_info'    => 'Если текст описания не будет задан система попытаятся составить его из содержимого прикрепленного документа'
  ],
  'popup'      => [
    'village_chose' => 'Выберите объект',
    'village'       => 'Объект',
    'services'      => 'Услуги',
    'products'      => 'Товары',
    'title'         => 'Вставить плейсхолдер в документ',
    'title_placeholder' => 'Вставить товар или услугу в документ',

  ],
  'messages'   => [
  ],
  'validation' => [
  ],
];
