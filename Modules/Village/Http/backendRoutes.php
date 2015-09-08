<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/village'], function (Router $router) {
        $router->bind('articles', function ($id) {
            return app('Modules\Village\Repositories\ArticleRepository')->find($id);
        });
        $router->resource('articles', 'ArticleController', ['except' => ['show'], 'names' => [
            'index' => 'admin.village.article.index',
            'create' => 'admin.village.article.create',
            'store' => 'admin.village.article.store',
            'edit' => 'admin.village.article.edit',
            'update' => 'admin.village.article.update',
            'destroy' => 'admin.village.article.destroy',
        ]]);
        $router->bind('buildings', function ($id) {
            return app('Modules\Village\Repositories\BuildingRepository')->find($id);
        });
        $router->resource('buildings', 'BuildingController', ['except' => ['show'], 'names' => [
            'index' => 'admin.village.building.index',
            'create' => 'admin.village.building.create',
            'store' => 'admin.village.building.store',
            'edit' => 'admin.village.building.edit',
            'update' => 'admin.village.building.update',
            'destroy' => 'admin.village.building.destroy',
        ]]);
        $router->bind('options', function ($id) {
            return app('Modules\Village\Repositories\OptionRepository')->find($id);
        });
        $router->resource('options', 'OptionController', ['except' => ['show'], 'names' => [
            'index' => 'admin.village.option.index',
            'create' => 'admin.village.option.create',
            'store' => 'admin.village.option.store',
            'edit' => 'admin.village.option.edit',
            'update' => 'admin.village.option.update',
            'destroy' => 'admin.village.option.destroy',
        ]]);
        $router->bind('products', function ($id) {
            return app('Modules\Village\Repositories\ProductRepository')->find($id);
        });
        $router->resource('products', 'ProductController', ['except' => ['show'], 'names' => [
            'index' => 'admin.village.product.index',
            'create' => 'admin.village.product.create',
            'store' => 'admin.village.product.store',
            'edit' => 'admin.village.product.edit',
            'update' => 'admin.village.product.update',
            'destroy' => 'admin.village.product.destroy',
        ]]);
        $router->bind('productcategories', function ($id) {
            return app('Modules\Village\Repositories\ProductCategoryRepository')->find($id);
        });
        $router->resource('productcategories', 'ProductCategoryController', ['except' => ['show'], 'names' => [
            'index' => 'admin.village.productcategory.index',
            'create' => 'admin.village.productcategory.create',
            'store' => 'admin.village.productcategory.store',
            'edit' => 'admin.village.productcategory.edit',
            'update' => 'admin.village.productcategory.update',
            'destroy' => 'admin.village.productcategory.destroy',
        ]]);
        $router->bind('productorders', function ($id) {
            return app('Modules\Village\Repositories\ProductOrderRepository')->find($id);
        });
        $router->resource('productorders', 'ProductOrderController', ['except' => ['show'], 'names' => [
            'index' => 'admin.village.productorder.index',
            'create' => 'admin.village.productorder.create',
            'store' => 'admin.village.productorder.store',
            'edit' => 'admin.village.productorder.edit',
            'update' => 'admin.village.productorder.update',
            'destroy' => 'admin.village.productorder.destroy',
        ]]);
        $router->bind('services', function ($id) {
            return app('Modules\Village\Repositories\ServiceRepository')->find($id);
        });
        $router->resource('services', 'ServiceController', ['except' => ['show'], 'names' => [
            'index' => 'admin.village.service.index',
            'create' => 'admin.village.service.create',
            'store' => 'admin.village.service.store',
            'edit' => 'admin.village.service.edit',
            'update' => 'admin.village.service.update',
            'destroy' => 'admin.village.service.destroy',
        ]]);
        $router->bind('servicecategories', function ($id) {
            return app('Modules\Village\Repositories\ServiceCategoryRepository')->find($id);
        });
        $router->resource('servicecategories', 'ServiceCategoryController', ['except' => ['show'], 'names' => [
            'index' => 'admin.village.servicecategory.index',
            'create' => 'admin.village.servicecategory.create',
            'store' => 'admin.village.servicecategory.store',
            'edit' => 'admin.village.servicecategory.edit',
            'update' => 'admin.village.servicecategory.update',
            'destroy' => 'admin.village.servicecategory.destroy',
        ]]);
        $router->bind('serviceorders', function ($id) {
            return app('Modules\Village\Repositories\ServiceOrderRepository')->find($id);
        });
        $router->resource('serviceorders', 'ServiceOrderController', ['except' => ['show'], 'names' => [
            'index' => 'admin.village.serviceorder.index',
            'create' => 'admin.village.serviceorder.create',
            'store' => 'admin.village.serviceorder.store',
            'edit' => 'admin.village.serviceorder.edit',
            'update' => 'admin.village.serviceorder.update',
            'destroy' => 'admin.village.serviceorder.destroy',
        ]]);
        $router->bind('surveys', function ($id) {
            return app('Modules\Village\Repositories\SurveyRepository')->find($id);
        });
        $router->resource('surveys', 'SurveyController', ['except' => ['show'], 'names' => [
            'index' => 'admin.village.survey.index',
            'create' => 'admin.village.survey.create',
            'store' => 'admin.village.survey.store',
            'edit' => 'admin.village.survey.edit',
            'update' => 'admin.village.survey.update',
            'destroy' => 'admin.village.survey.destroy',
        ]]);
        $router->bind('surveyvotes', function ($id) {
            return app('Modules\Village\Repositories\SurveyVoteRepository')->find($id);
        });
        $router->resource('surveyvotes', 'SurveyVoteController', ['except' => ['show'], 'names' => [
            'index' => 'admin.village.surveyvote.index',
            'create' => 'admin.village.surveyvote.create',
            'store' => 'admin.village.surveyvote.store',
            'edit' => 'admin.village.surveyvote.edit',
            'update' => 'admin.village.surveyvote.update',
            'destroy' => 'admin.village.surveyvote.destroy',
        ]]);
        $router->bind('tokens', function ($id) {
            return app('Modules\Village\Repositories\TokenRepository')->find($id);
        });
        $router->resource('tokens', 'TokenController', ['except' => ['show'], 'names' => [
            'index' => 'admin.village.token.index',
            'create' => 'admin.village.token.create',
            'store' => 'admin.village.token.store',
            'edit' => 'admin.village.token.edit',
            'update' => 'admin.village.token.update',
            'destroy' => 'admin.village.token.destroy',
        ]]);
        $router->bind('margins', function ($id) {
            return app('Modules\Village\Repositories\MarginRepository')->find($id);
        });
        $router->resource('margins', 'MarginController', ['except' => ['show'], 'names' => [
            'index' => 'admin.village.margin.index',
            'create' => 'admin.village.margin.create',
            'store' => 'admin.village.margin.store',
            'edit' => 'admin.village.margin.edit',
            'update' => 'admin.village.margin.update',
            'destroy' => 'admin.village.margin.destroy',
        ]]);
// append













});
