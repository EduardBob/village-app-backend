<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/payment', 'middleware' => ['secure']], function (Router $router) {
    $router->get('/redirect', [
        'as' => 'sentry.payment.redirect', 'uses' => 'SentryPaymentController@redirect'
    ]);
});

// payment process
$router->get('/payment/status', [
    'as' => 'sentry.payment.process', 'uses' => 'SentryPaymentController@process'
]);

// Register form.
$router->get('/register', [
  'as' => 'user.facility.registration', 'uses' => 'Frontend\FacilityRegistrationController@index'
]);