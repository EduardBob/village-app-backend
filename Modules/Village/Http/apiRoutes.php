<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' =>'v1'], function (Router $router) {
    $router->group([], function (Router $router) {
        $router->group(['prefix' =>'auth'], function (Router $router) {
            $router->post('',        ['uses' => 'V1\AuthController@index', 'as' => 'village.api.user.auth.index']);
        });

//        $router->group(['prefix' =>'auth', 'middleware' => ['jwt.auth', 'jwt.refresh']], function (Router $router) {
//            $router->post('',        ['uses' => 'V1\AuthController@refresh', 'as' => 'village.api.user.auth.refresh']);
//        });

        $router->group(['prefix' =>'settings'], function (Router $router) {
            $router->get('',        ['uses' => 'V1\SettingController@index', 'as' => 'village.api.setting.setting.list']);
        });
    });

    $router->group(['middleware' => ['jwt.auth', 'jwt.refresh']], function (Router $router) {
        $router->group(['prefix' =>'me'], function (Router $router) {
            $router->get('',        ['uses' => 'V1\MeController@me', 'as' => 'village.api.user.me.me']);
        });

        $router->group(['prefix' =>'buildings'], function (Router $router) {
            $router->get('{code}',        ['uses' => 'V1\BuildingController@show', 'as' => 'village.api.building.building.one']);
        });

//        $router->group(['prefix' =>'users'], function (Router $router) {
//            $router->get('',        ['uses' => 'V1\UserController@index', 'as' => 'village.api.user.list']);
//            $router->get('{id}', 	['uses' => 'V1\UserController@show', 'as' => 'village.api.user.one']);
//        $router->post('', 		['uses' => 'UserController@store']);
//        $router->patch('{id}',  ['uses' => 'UserController@update']);
//        $router->delete('{id}', ['uses' => 'UserController@destroy']);
//        });

        $router->group(['prefix' =>'articles'], function (Router $router) {
            $router->get('',        ['uses' => 'V1\ArticleController@index', 'as' => 'village.api.article.list']);
            $router->get('{id}', 	['uses' => 'V1\ArticleController@show', 'as' => 'village.api.article.one']);
        });

        $router->group(['prefix' =>'services'], function (Router $router) {
            $router->get('',        ['uses' => 'V1\ServiceController@index', 'as' => 'village.api.service.service.list']);

            $router->group(['prefix' =>'categories'], function (Router $router) {
                $router->get('',        ['uses' => 'V1\ServiceCategoryController@index', 'as' => 'village.api.service.category.list']);
            });

            $router->group(['prefix' =>'orders'], function (Router $router) {
                $router->get('',        ['uses' => 'V1\ServiceOrderController@index', 'as' => 'village.api.service.order.list']);
                $router->post('',       ['uses' => 'V1\ServiceOrderController@store', 'as' => 'village.api.service.order.store']);
            });
        });

        $router->group(['prefix' =>'products'], function (Router $router) {
            $router->get('',        ['uses' => 'V1\ProductController@index', 'as' => 'village.api.product.product.list']);

            $router->group(['prefix' =>'categories'], function (Router $router) {
                $router->get('',        ['uses' => 'V1\ProductCategoryController@index', 'as' => 'village.api.product.category.list']);
            });

            $router->group(['prefix' =>'orders'], function (Router $router) {
                $router->get('',        ['uses' => 'V1\ProductOrderController@index', 'as' => 'village.api.product.order.list']);
                $router->post('',       ['uses' => 'V1\ProductOrderController@store', 'as' => 'village.api.product.order.store']);
            });
        });
    });
});
