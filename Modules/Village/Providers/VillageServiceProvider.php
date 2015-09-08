<?php namespace Modules\Village\Providers;

use Illuminate\Support\ServiceProvider;

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

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Village\Repositories\UserRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentUserRepository(new \Modules\Village\Entities\User());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheUserDecorator($repository);
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
            'Modules\Village\Repositories\MarginRepository',
            function () {
                $repository = new \Modules\Village\Repositories\Eloquent\EloquentMarginRepository(new \Modules\Village\Entities\Margin());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Village\Repositories\Cache\CacheMarginDecorator($repository);
            }
        );
// add bindings














    }
}
