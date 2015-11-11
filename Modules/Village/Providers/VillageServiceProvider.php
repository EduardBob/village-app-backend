<?php namespace Modules\Village\Providers;

use Fruitware\ProstorSms\Exception\BadSmsStatusException;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Contracts\Authentication;
use Modules\Media\Image\ThumbnailsManager;
use Modules\Village\Entities\ProductOrder;
use Modules\Village\Entities\ProductOrderChange;
use Modules\Village\Entities\ServiceOrder;
use Modules\Village\Entities\ServiceOrderChange;
use Modules\Village\Entities\Sms;

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
        return [];
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

                if ('processing' === $productOrder->status) {
                    $this->sendSmsOnProcessingOrder($auth);
                }
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

                if ('processing' === $serviceOrder->status) {
                    $this->sendSmsOnProcessingOrder($auth);
                }
            }
        });
    }

    /**
     * @param Authentication $auth
     */
    private function sendSmsOnProcessingOrder(Authentication $auth)
    {
        if (config('village.sms.enabled.on_order_processing')) {
            $user = $this->user($auth);
            $sms = new Sms();
            $sms->village()
                ->associate($user->village)
            ;
            $sms
                ->setPhone($user->village->main_admin->phone)
                ->setText('Добавлен новый заказ')
//                ->setSender($user->village->name)
            ;
            try {
                smsGate()->send($sms);
            }
            catch (\Exception $ex) {
            }
        }
        else {
            flash()->warning(trans('village::sms.messages.send on_order_processing disabled'));
        }
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
                return new \Modules\Village\Repositories\Eloquent\EloquentUserRoleRepository();
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ArticleRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentArticleRepository(new \Modules\Village\Entities\Article());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\VillageRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentVillageRepository(new \Modules\Village\Entities\Village());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\BuildingRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentBuildingRepository(new \Modules\Village\Entities\Building());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\MarginRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentMarginRepository(new \Modules\Village\Entities\Margin());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\OptionRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentOptionRepository(new \Modules\Village\Entities\Option());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ProductRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentProductRepository(new \Modules\Village\Entities\Product());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ProductCategoryRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentProductCategoryRepository(new \Modules\Village\Entities\ProductCategory());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ProductOrderRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentProductOrderRepository(new \Modules\Village\Entities\ProductOrder());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ProductOrderChangeRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentProductOrderChangeRepository(new \Modules\Village\Entities\ProductOrderChange());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ServiceOrderChangeRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentServiceOrderChangeRepository(new \Modules\Village\Entities\ServiceOrderChange());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ServiceRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentServiceRepository(new \Modules\Village\Entities\Service());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ServiceCategoryRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentServiceCategoryRepository(new \Modules\Village\Entities\ServiceCategory());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\ServiceOrderRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentServiceOrderRepository(new \Modules\Village\Entities\ServiceOrder());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\SurveyRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentSurveyRepository(new \Modules\Village\Entities\Survey());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\SurveyVoteRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentSurveyVoteRepository(new \Modules\Village\Entities\SurveyVote());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\TokenRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentTokenRepository(new \Modules\Village\Entities\Token());
            }
        );

        $this->app->bind(
            'Modules\Village\Repositories\SmsRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentSmsRepository(new \Modules\Village\Entities\Sms());
            }
        );
    }
}
