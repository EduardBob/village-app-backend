<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => 'file'], function (Router $router) {
    $router->get('{id}', 	['uses' => 'V1\FileController@show', 'as' => 'village.api.file.one']);
});


$router->group(['prefix' => 'v1'], function (Router $router) {

    // without token
    $router->group([], function (Router $router) {

        // апи для охранников
        $router->group(['prefix' => 'security'], function (Router $router) {
            $router->group(['prefix' => 'auth'], function (Router $router) {
                $router->post('token',        ['uses' => 'V1\Security\AuthController@auth', 'as' => 'village.security.api.user.auth.auth']);
            });
        });

        $router->group(['prefix' => 'buildings'], function (Router $router) {
            $router->get('{code}',        ['uses' => 'V1\BuildingController@show', 'as' => 'village.api.building.building.one']);
        });

        $router->group(['prefix' => 'auth'], function (Router $router) {
            $router->post('token',        ['uses' => 'V1\AuthController@auth', 'as' => 'village.api.user.auth.auth']);
        });

        $router->group(['prefix' => 'auth', 'middleware' => ['jwt.refresh']], function (Router $router) {
            $router->post('refresh',        ['uses' => 'V1\AuthController@refresh', 'as' => 'village.api.user.auth.refresh']);
        });

        $router->group(['prefix' => 'settings'], function (Router $router) {
            $router->get('',        ['uses' => 'V1\SettingController@index', 'as' => 'village.api.setting.setting.list']);
        });

        $router->group(['prefix' => 'users'], function (Router $router) {
            $router->post('', 		        ['uses' => 'V1\UserController@registration', 'as' => 'village.api.user.user.registration']);
            $router->post('confirm', 		['uses' => 'V1\UserController@registrationConfirm', 'as' => 'village.api.user.user.registration_confirm']);
            $router->post('reset', 	        ['uses' => 'V1\UserController@reset', 'as' => 'village.api.user.user.reset']);
        });

        $router->group(['prefix' => 'tokens'], function (Router $router) {
            $router->post('', 		        ['uses' => 'V1\TokenController@store', 'as' => 'village.api.token.store']);
            $router->post('check', 	        ['uses' => 'V1\TokenController@check', 'as' => 'village.api.token.check']);
        });

        $router->group(['prefix' => 'villages'], function (Router $router) {
            $router->post('partner-request', ['uses' => 'V1\VillageController@partnerRequest', 'as' => 'village.api.village.village.partner_request']);
            $router->post('request',        ['uses' => 'V1\VillageController@request', 'as' => 'village.api.village.village.request']);
        });
    });

    // with token
    $router->group(['middleware' => ['jwt.auth']], function (Router $router) {

        $router->group(['prefix' => 'security', 'middleware' => ['role:security']], function (Router $router) {
            $router->group(['prefix' => 'services'], function (Router $router) {
                $router->group(['prefix' => 'orders'], function (Router $router) {
                    $router->get('', ['uses' => 'V1\Security\ServiceOrderController@index', 'as' => 'village.security.api.service.order.list']);
                    $router->get('{id}',    ['uses' => 'V1\Security\ServiceOrderController@show', 'as' => 'village.security.api.service.order.show']);
                    $router->post('',       ['uses' => 'V1\Security\ServiceOrderController@store', 'as' => 'village.security.api.service.order.store']);
                    $router->patch('{id}',  ['uses' => 'V1\Security\ServiceOrderController@update', 'as' => 'village.security.api.service.order.update']);
                });

                $router->get('',        ['uses' => 'V1\Security\ServiceController@index', 'as' => 'village.security.api.service.service.list']);
            });
        });
        // User methods.
        $router->group(['prefix' => 'me'], function (Router $router) {
            $router->get('',            ['uses' => 'V1\MeController@me', 'as' => 'village.api.user.me.me']);
            $router->post('name', 		['uses' => 'V1\MeController@changeName', 'as' => 'village.api.user.me.name']);
            $router->post('email', 		['uses' => 'V1\MeController@changeEmail', 'as' => 'village.api.user.me.email']);
            $router->post('password', 	['uses' => 'V1\MeController@changePassword', 'as' => 'village.api.user.me.password']);
            $router->post('phone', 	    ['uses' => 'V1\MeController@changePhone', 'as' => 'village.api.user.me.phone']);
            // Device token operations.
            $router->post('device',       ['uses' => 'V1\MeController@changeDevice', 'as' => 'village.api.user.me.change_device']);
            $router->post('device-delete', ['uses' => 'V1\MeController@deleteDevice', 'as' => 'village.api.user.me.delete_device']);
            // Subscribe/Unsubsribe user from mail notifications.
            $router->post('mail-notifications',       ['uses' => 'V1\MeController@mailSubscribe', 'as' => 'village.api.user.me.mail_subscribe']);
        });

//        $router->group(['prefix' => 'users'], function (Router $router) {
//            $router->get('',        ['uses' => 'V1\UserController@index', 'as' => 'village.api.user.user.list']);
//            $router->get('{id}', 	['uses' => 'V1\UserController@show', 'as' => 'village.api.user.user.one']);
//        $router->post('', 		['uses' => 'UserController@store', 'as' => 'village.api.user.user.store']);
//        $router->patch('{id}',  ['uses' => 'UserController@update', 'as' => 'village.api.user.user.update']);
//        $router->delete('{id}', ['uses' => 'UserController@destroy', 'as' => 'village.api.user.user.destroy']);
//        });

        $router->group(['prefix' => 'articles'], function (Router $router) {
            $router->group(['prefix' => 'categories'], function (Router $router) {
                $router->get('',    ['uses' => 'V1\ArticleCategoryController@index', 'as' => 'village.api.article.category.list']);
            });
            $router->get('',        ['uses' => 'V1\ArticleController@index', 'as' => 'village.api.article.list']);
            $router->get('{id}', 	['uses' => 'V1\ArticleController@show', 'as' => 'village.api.article.one']);

        });


        $router->group(['prefix' => 'documents'], function (Router $router) {
            $router->group(['prefix' => 'categories'], function (Router $router) {
                $router->get('',    ['uses' => 'V1\DocumentCategoryController@index', 'as' => 'village.api.article.category.list']);
            });
            $router->get('',        ['uses' => 'V1\DocumentController@index', 'as' => 'village.api.document.list']);
            $router->get('{id}', 	['uses' => 'V1\DocumentController@show', 'as' => 'village.api.document.one']);

        });

        $router->group(['prefix' => 'services'], function (Router $router) {
            $router->group(['prefix' => 'categories'], function (Router $router) {
                $router->get('',        ['uses' => 'V1\ServiceCategoryController@index', 'as' => 'village.api.service.category.list']);
            });

            $router->group(['prefix' => 'orders'], function (Router $router) {
	            $router->get('{id}/payment',       ['uses' => 'V1\ServiceOrderController@checkPayment', 'as' => 'village.api.service.order.payment.check']);
                $router->get('',        ['uses' => 'V1\ServiceOrderController@index', 'as' => 'village.api.service.order.list']);
                $router->post('',       ['uses' => 'V1\ServiceOrderController@store', 'as' => 'village.api.service.order.store']);
            });

            $router->get('',            ['uses' => 'V1\ServiceController@index', 'as' => 'village.api.service.service.list']);
            $router->get('{id}',        ['uses' => 'V1\ServiceController@show', 'as' => 'village.api.service.service.one']);
        });

        $router->group(['prefix' => 'products'], function (Router $router) {
            $router->group(['prefix' => 'categories'], function (Router $router) {
                $router->get('',        ['uses' => 'V1\ProductCategoryController@index', 'as' => 'village.api.product.category.list']);
            });

            $router->group(['prefix' => 'orders'], function (Router $router) {
	            $router->get('{id}/payment',       ['uses' => 'V1\ProductOrderController@checkPayment', 'as' => 'village.api.product.order.payment.check']);
                $router->get('',        ['uses' => 'V1\ProductOrderController@index', 'as' => 'village.api.product.order.list']);
                $router->post('',       ['uses' => 'V1\ProductOrderController@store', 'as' => 'village.api.product.order.store']);
            });

            $router->get('',            ['uses' => 'V1\ProductController@index', 'as' => 'village.api.product.product.list']);
            $router->get('{id}',        ['uses' => 'V1\ProductController@show', 'as' => 'village.api.product.product.one']);
        });

        $router->group(['prefix' => 'surveys'], function (Router $router) {
            $router->get('/current',    ['uses' => 'V1\SurveyController@current', 'as' => 'village.api.survey.current']);
            $router->post('{id}', 	    ['uses' => 'V1\SurveyController@vote', 'as' => 'village.api.survey.vote']);
        });
        // Smart home methods.
        $router->group(['prefix' => 'smarthome'], function (Router $router) {
            $router->get('',            ['uses' => 'V1\SmartHomeController@index', 'as' => 'village.api.smarthome.index']);
            $router->group(['prefix' => 'statuses'], function (Router $router) {
                $router->get('',        ['uses' => 'V1\SmartHomeController@statuses', 'as' => 'village.api.smarthome.statuses']);
            });
            $router->group(['prefix' => 'add'], function (Router $router) {
                $router->post('',       ['uses' => 'V1\SmartHomeController@add', 'as' => 'village.api.smarthome.add']);
            });
        });
    });
});
