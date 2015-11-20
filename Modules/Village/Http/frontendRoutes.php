<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/payment', 'middleware' => ['secure']], function (Router $router) {
    $router->get('/redirect', [
        'as' => 'sentry.payment.redirect', 'uses' => 'SentryPaymentController@redirect'
    ]);
    $router->post('/process', [
        'as' => 'sentry.payment.process', 'uses' => 'SentryPaymentController@process'
    ]);
});