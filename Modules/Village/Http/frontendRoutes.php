<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/payment', 'middleware' => ['secure']], function (Router $router) {
    $router->get('/redirect', [
        'as' => 'sentry.payment.redirect', 'uses' => 'SentryPaymentController@redirect'
    ]);
});

// payment process
$router->post('/', [
    'as' => 'sentry.payment.process', 'uses' => 'SentryPaymentController@process'
]);