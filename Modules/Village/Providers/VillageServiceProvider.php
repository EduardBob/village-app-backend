<?php namespace Modules\Village\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Contracts\Authentication;
use Modules\Media\Image\ThumbnailsManager;
use Modules\Village\Entities\ProductOrder;
use Modules\Village\Entities\ProductOrderChange;
use Modules\Village\Entities\ServiceOrder;
use Modules\Village\Entities\ServiceOrderChange;

class VillageServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Authentication $auth)
    {
        ProductOrder::saved(function(ProductOrder $productOrder) use ($auth) {
            if ($productOrder->isDirty('status')) {
                ProductOrderChange::create([
                    'order_id' => $productOrder->id,
                    'user_id' => $this->user($auth)->id,
                    'from_status' => @$productOrder->getOriginal()['status'],
                    'to_status' => $productOrder->status,
                ]);
            }
        });

        ServiceOrder::saved(function(ServiceOrder $serviceOrder) use ($auth) {
            if ($serviceOrder->isDirty('status')) {
                ServiceOrderChange::create([
                    'order_id' => $serviceOrder->id,
                    'user_id' => $this->user($auth)->id,
                    'from_status' => @$serviceOrder->getOriginal()['status'],
                    'to_status' => $serviceOrder->status,
                ]);
            }
        });
    }

    private function user(Authentication $auth)
    {
        if ($user = $auth->check()) {
            return $user;
        }
        elseif (\JWTAuth::parseToken()) {
            return \JWTAuth::parseToken()->authenticate();
        }
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\User\Http\Controllers\AuthController',
            'Modules\Village\Http\Controllers\AuthController'
        );

        $this->app->bind(
            'Modules\User\Http\Requests\LoginRequest',
            'Modules\Village\Http\Requests\LoginRequest'
        );

        $this->app->bind(
            'Modules\Village\Repositories\UserRoleRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentUserRoleRepository();

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheUserRoleDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ArticleRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentArticleRepository(new \Modules\Village\Entities\Article());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheArticleDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\VillageRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentVillageRepository(new \Modules\Village\Entities\Village());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheVillageDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\BuildingRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentBuildingRepository(new \Modules\Village\Entities\Building());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheBuildingDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\MarginRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentMarginRepository(new \Modules\Village\Entities\Margin());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheMarginDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\OptionRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentOptionRepository(new \Modules\Village\Entities\Option());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheOptionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ProductRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentProductRepository(new \Modules\Village\Entities\Product());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheProductDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ProductCategoryRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentProductCategoryRepository(new \Modules\Village\Entities\ProductCategory());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheProductCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ProductOrderRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentProductOrderRepository(new \Modules\Village\Entities\ProductOrder());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheProductOrderDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ProductOrderChangeRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentProductOrderChangeRepository(new \Modules\Village\Entities\ProductOrderChange());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheProductOrderChangeDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ServiceOrderChangeRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentServiceOrderChangeRepository(new \Modules\Village\Entities\ServiceOrderChange());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheServiceOrderChangeDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ServiceRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentServiceRepository(new \Modules\Village\Entities\Service());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheServiceDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ServiceCategoryRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentServiceCategoryRepository(new \Modules\Village\Entities\ServiceCategory());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheServiceCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ServiceOrderRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentServiceOrderRepository(new \Modules\Village\Entities\ServiceOrder());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheServiceOrderDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\SurveyRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentSurveyRepository(new \Modules\Village\Entities\Survey());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheSurveyDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\SurveyVoteRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentSurveyVoteRepository(new \Modules\Village\Entities\SurveyVote());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheSurveyVoteDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\TokenRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentTokenRepository(new \Modules\Village\Entities\Token());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheTokenDecorator($repository);
            }
        );
    }
}
