<?php

return array(
  'ios' => array(
    'environment' => env('PUSH_ENV'),
    'certificate' => base_path('config/push/dev.pem'),
    'passPhrase'  => env('PUSH_IOS_PASS_PHRASE'),
    'service'     => 'apns'
  ),
  'gcm' => array(
    'environment' => env('PUSH_ENV'),
    'apiKey'      => env('PUSH_ANDROID_API_KEY'),
    'service'     => 'gcm'
  )
);
