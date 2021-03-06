<?php use Modules\Village\Services\Packet;

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

$settings += Packet::getSettings();

return $settings;
