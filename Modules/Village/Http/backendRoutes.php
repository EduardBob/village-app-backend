<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/village'], function (Router $router) {
    $router->bind('villages', function ($id) {
        return \Modules\Village\Entities\Village::withTrashed()->find($id);
    });
    $router->resource('villages', 'VillageController', ['except' => ['show'], 'names' => [
        'index' => 'admin.village.village.index',
        'create' => 'admin.village.village.create',
        'store' => 'admin.village.village.store',
        'edit' => 'admin.village.village.edit',
        'update' => 'admin.village.village.update',
        'destroy' => 'admin.village.village.destroy',
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
    $router->group(['prefix' => 'buildings'], function (Router $router) {
        $router->get('get-choices-by-village/{byVillageId}', ['uses' => 'BuildingController@getChoicesByVillage', 'as' => 'admin.village.building.get_choices_by_village']);
        $router->get('get-choices-by-village/{byVillageId}/{selectedBuildingId}', ['uses' => 'BuildingController@getChoicesByVillage', 'as' => 'admin.village.building.get_choices_by_village']);
    });

    $router->bind('basearticles', function ($id) {
        return \Modules\Village\Entities\BaseArticle::find($id);
    });
    $router->resource('basearticles', 'BaseArticleController', ['names' => [
        'index' => 'admin.village.basearticle.index',
        'show' => 'admin.village.basearticle.show',
        'create' => 'admin.village.basearticle.create',
        'store' => 'admin.village.basearticle.store',
        'edit' => 'admin.village.basearticle.edit',
        'update' => 'admin.village.basearticle.update',
        'destroy' => 'admin.village.basearticle.destroy',
        'copy' => 'admin.village.basearticle.copy',
    ]]);

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
    $router->group(['prefix' => 'articles'], function (Router $router) {
        $router->get('{id}/base-copy', ['uses' => 'ArticleController@baseCopy', 'as' => 'admin.village.article.baseCopy']);
    });

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

    $router->bind('baseproducts', function ($id) {
        return \Modules\Village\Entities\BaseProduct::find($id);
    });
    $router->resource('baseproducts', 'BaseProductController', ['names' => [
        'index' => 'admin.village.baseproduct.index',
        'show' => 'admin.village.baseproduct.show',
        'create' => 'admin.village.baseproduct.create',
        'store' => 'admin.village.baseproduct.store',
        'edit' => 'admin.village.baseproduct.edit',
        'update' => 'admin.village.baseproduct.update',
        'destroy' => 'admin.village.baseproduct.destroy',
        'copy' => 'admin.village.baseproduct.copy',
    ]]);
    $router->bind('products', function ($id) {
        return \Modules\Village\Entities\Product::withTrashed()->find($id);
    });
    $router->resource('products', 'ProductController', ['except' => ['show'], 'names' => [
        'index' => 'admin.village.product.index',
        'create' => 'admin.village.product.create',
        'store' => 'admin.village.product.store',
        'edit' => 'admin.village.product.edit',
        'update' => 'admin.village.product.update',
        'destroy' => 'admin.village.product.destroy',
    ]]);
    $router->group(['prefix' => 'products'], function (Router $router) {
        $router->get('{id}/base-copy', ['uses' => 'ProductController@baseCopy', 'as' => 'admin.village.product.baseCopy']);
    });

    $router->bind('productcategories', function ($id) {
        return \Modules\Village\Entities\ProductCategory::withTrashed()->find($id);
    });
    $router->resource('productcategories', 'ProductCategoryController', ['except' => ['show'], 'names' => [
        'index' => 'admin.village.productcategory.index',
        'create' => 'admin.village.productcategory.create',
        'store' => 'admin.village.productcategory.store',
        'edit' => 'admin.village.productcategory.edit',
        'update' => 'admin.village.productcategory.update',
        'destroy' => 'admin.village.productcategory.destroy',
    ]]);
    $router->group(['prefix' => 'productcategories'], function (Router $router) {
        $router->get('get-choices-by-village/{byVillageId}', ['uses' => 'ProductCategoryController@getChoicesByVillage', 'as' => 'admin.village.productcategory.get_choices_by_village']);
        $router->get('get-choices-by-village/{byVillageId}/{selectedId}', ['uses' => 'ProductCategoryController@getChoicesByVillage', 'as' => 'admin.village.productcategory.get_choices_by_village']);
    });
    $router->bind('productorders', function ($id) {
        return app('Modules\Village\Repositories\ProductOrderRepository')->find($id);
    });
    $router->resource('productorders', 'ProductOrderController', ['names' => [
        'index' => 'admin.village.productorder.index',
        'show' => 'admin.village.productorder.show',
        'create' => 'admin.village.productorder.create',
        'store' => 'admin.village.productorder.store',
        'edit' => 'admin.village.productorder.edit',
        'update' => 'admin.village.productorder.update',
        'destroy' => 'admin.village.productorder.destroy',
    ]]);
    $router->group(['prefix' => 'productorders'], function (Router $router) {
        $router->put('{id}/running', ['uses' => 'ProductOrderController@setStatusRunning', 'as' => 'admin.village.productorder.set_status_running']);
        $router->put('{id}/done', 	 ['uses' => 'ProductOrderController@setStatusDone', 'as' => 'admin.village.productorder.set_status_done']);
    });
    $router->resource('productorderchanges', 'ProductOrderChangeController', ['except' => ['show', 'create', 'store', 'edit', 'update', 'destroy'], 'names' => [
        'index' => 'admin.village.productorderchange.index',
    ]]);

    $router->bind('services', function ($id) {
        return \Modules\Village\Entities\Service::withTrashed()->find($id);
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
        return \Modules\Village\Entities\ServiceCategory::withTrashed()->find($id);
    });
    $router->resource('servicecategories', 'ServiceCategoryController', ['except' => ['show'], 'names' => [
        'index' => 'admin.village.servicecategory.index',
        'create' => 'admin.village.servicecategory.create',
        'store' => 'admin.village.servicecategory.store',
        'edit' => 'admin.village.servicecategory.edit',
        'update' => 'admin.village.servicecategory.update',
        'destroy' => 'admin.village.servicecategory.destroy',
    ]]);
    $router->group(['prefix' => 'servicecategories'], function (Router $router) {
        $router->get('get-choices-by-village/{byVillageId}', ['uses' => 'ServiceCategoryController@getChoicesByVillage', 'as' => 'admin.village.servicecategory.get_choices_by_village']);
        $router->get('get-choices-by-village/{byVillageId}/{selectedId}', ['uses' => 'ServiceCategoryController@getChoicesByVillage', 'as' => 'admin.village.servicecategory.get_choices_by_village']);
    });
    $router->bind('serviceorders', function ($id) {
        return app('Modules\Village\Repositories\ServiceOrderRepository')->find($id);
    });
    $router->resource('serviceorders', 'ServiceOrderController', ['names' => [
        'index' => 'admin.village.serviceorder.index',
        'show' => 'admin.village.serviceorder.show',
        'create' => 'admin.village.serviceorder.create',
        'store' => 'admin.village.serviceorder.store',
        'edit' => 'admin.village.serviceorder.edit',
        'update' => 'admin.village.serviceorder.update',
        'destroy' => 'admin.village.serviceorder.destroy',
    ]]);
    $router->group(['prefix' => 'serviceorders'], function (Router $router) {
        $router->put('{id}/running', ['uses' => 'ServiceOrderController@setStatusRunning', 'as' => 'admin.village.serviceorder.set_status_running']);
        $router->put('{id}/done', 	 ['uses' => 'ServiceOrderController@setStatusDone', 'as' => 'admin.village.serviceorder.set_status_done']);
    });
    $router->resource('serviceorderchanges', 'ServiceOrderChangeController', ['except' => ['show', 'create', 'store', 'edit', 'update', 'destroy'], 'names' => [
        'index' => 'admin.village.serviceorderchange.index',
    ]]);

    $router->bind('basesurveys', function ($id) {
        return \Modules\Village\Entities\BaseSurvey::find($id);
    });
    $router->resource('basesurveys', 'BaseSurveyController', ['names' => [
        'index' => 'admin.village.basesurvey.index',
        'show' => 'admin.village.basesurvey.show',
        'create' => 'admin.village.basesurvey.create',
        'store' => 'admin.village.basesurvey.store',
        'edit' => 'admin.village.basesurvey.edit',
        'update' => 'admin.village.basesurvey.update',
        'destroy' => 'admin.village.basesurvey.destroy',
        'copy' => 'admin.village.basesurvey.copy',
    ]]);

    $router->bind('surveys', function ($id) {
        return \Modules\Village\Entities\Survey::withTrashed()->find($id);
    });
    $router->resource('surveys', 'SurveyController', ['except' => ['show'], 'names' => [
        'index' => 'admin.village.survey.index',
        'create' => 'admin.village.survey.create',
        'store' => 'admin.village.survey.store',
        'edit' => 'admin.village.survey.edit',
        'update' => 'admin.village.survey.update',
        'destroy' => 'admin.village.survey.destroy',
    ]]);
    $router->group(['prefix' => 'surveys'], function (Router $router) {
        $router->get('{id}/base-copy', ['uses' => 'SurveyController@baseCopy', 'as' => 'admin.village.survey.baseCopy']);
    });
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

//    $router->resource('buildings', 'BuildingController', ['except' => ['show', 'index', 'create', 'store', 'edit', 'update', 'destroy'], 'names' => [
//        'send' => 'admin.village.building.send',
//    ]]);
    $router->group(['prefix' => 'sms'], function (Router $router) {
        $router->post('send', ['uses' => 'SmsController@send', 'as' => 'admin.village.sms.send']);
    });
//        $router->resource('tokens', 'TokenController', ['except' => ['show'], 'names' => [
//            'index' => 'admin.village.token.index',
//            'create' => 'admin.village.token.create',
//            'store' => 'admin.village.token.store',
//            'edit' => 'admin.village.token.edit',
//            'update' => 'admin.village.token.update',
//            'destroy' => 'admin.village.token.destroy',
//        ]]);
//        $router->bind('users', function ($id) {
//            return app('Modules\Village\Repositories\UserRepository')->find($id);
//        });
//        $router->resource('users', 'UserController', ['except' => ['show'], 'names' => [
//            'index' => 'admin.village.user.index',
//            'create' => 'admin.village.user.create',
//            'store' => 'admin.village.user.store',
//            'edit' => 'admin.village.user.edit',
//            'update' => 'admin.village.user.update',
//            'destroy' => 'admin.village.user.destroy',
//        ]]);
// append














});
