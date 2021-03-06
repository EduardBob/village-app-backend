<?php

return [
    'site-name' => [
        'description' => 'core::settings.site-name',
        'view' => 'text',
        'translatable' => false,
    ],
    'site-description' => [
        'description' => 'core::settings.site-description',
        'view' => 'textarea',
        'translatable' => false,
    ],
    'template' => [
        'description' => 'core::settings.template',
        'view' => 'core::fields.select-theme',
    ],
    'google-analytics' => [
        'description' => 'core::settings.google-analytics',
        'view' => 'textarea',
        'translatable' => false,
    ],
    'locales' => [
        'description' => 'core::settings.locales',
        'view' => 'core::fields.select-locales',
        'translatable' => false,
    ],
];
