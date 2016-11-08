<?php
use Modules\Village\Entities\Village;

$settings = [
  'village-request-send-to-emails' => [
    'description' => 'Email-ы для получения заявок о партнёрстве (через запятую)',
    'view' => 'text',
    'translatable' => false,
  ],
  'village-agreement-condition' => [
    'description' => 'Текст пользовательского соглашение',
    'view' => 'wysiwyg',
    'translatable' => false,
  ]
];
$settings +=  Village::getSettings();

return $settings;
