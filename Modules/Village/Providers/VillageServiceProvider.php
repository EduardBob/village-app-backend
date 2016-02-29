<?php namespace Modules\Village\Providers;

use Fruitware\ProstorSms\Exception\BadSmsStatusException;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Contracts\Authentication;
use Modules\Media\Image\ThumbnailsManager;
use Modules\Village\Entities\Product;
use Modules\Village\Entities\ProductOrder;
use Modules\Village\Entities\ProductOrderChange;
use Modules\Village\Entities\Service;
use Modules\Village\Entities\ServiceOrder;
use Modules\Village\Entities\ServiceOrderChange;
use Modules\Village\Entities\Sms;
use Modules\Village\Entities\User;
use Modules\Village\Services\SentryPaymentGateway;

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
        ProductOrder::created(function(ProductOrder $productOrder) {
            if ($productOrder::PAYMENT_TYPE_CARD === $productOrder->payment_type) {
	            if ($productOrder->has_card_payment) {
		            $payment = new SentryPaymentGateway();
		            $orderId = $productOrder->getOrderNameForCardPayment();

		            try {
			            $transactionId = $payment
				            ->generateTransaction(
					            $orderId,
					            $productOrder->price,
					            route('sentry.payment.process', [], true)
				            )
			            ;

			            $productOrder->transaction_id = $transactionId;
			            $productOrder->save();
		            }
		            catch(\Exception $ex) {
			            $productOrder->status = $productOrder::STATUS_REJECTED;
			            $productOrder->decline_reason = $ex->getMessage();
			            $productOrder->save();
		            }
	            }
	            else {
		            $productOrder->payment_type = $productOrder::PAYMENT_TYPE_CASH;
		            $productOrder->save();
	            }
            }
        }, -1);

        ProductOrder::saved(function(ProductOrder $productOrder) use ($auth) {
            if ($productOrder->isDirty('status')) {
                ProductOrderChange::create([
                    'order_id' => $productOrder->id,
                    'user_id' => $this->user($auth)->id,
                    'from_status' => @$productOrder->getOriginal()['status'],
                    'to_status' => $productOrder->status,
                ]);

                if ('processing' === $productOrder->status) {
                    $this->sendMailOnProcessingOrder($auth, $productOrder);
                    $this->sendSmsOnProcessingOrder($auth, $productOrder);
                }
            }
        });

        ServiceOrder::created(function(ServiceOrder $serviceOrder) {
            if ($serviceOrder::PAYMENT_TYPE_CARD === $serviceOrder->payment_type) {
	            if ($serviceOrder->has_card_payment) {
		            $payment = new SentryPaymentGateway();
		            $orderId = $serviceOrder->getOrderNameForCardPayment();

		            try {
			            $transactionId = $payment
				            ->generateTransaction(
					            $orderId,
					            $serviceOrder->price,
					            route('sentry.payment.process', [], true)
				            )
			            ;

			            $serviceOrder->transaction_id = $transactionId;
			            $serviceOrder->save();
		            }
		            catch(\Exception $ex) {
			            $serviceOrder->status = $serviceOrder::STATUS_REJECTED;
			            $serviceOrder->decline_reason = $ex->getMessage();
			            $serviceOrder->save();
		            }
	            }
	            else {
		            $serviceOrder->payment_type = $serviceOrder::PAYMENT_TYPE_CASH;
		            $serviceOrder->save();
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
                    $this->sendMailOnProcessingOrder($auth, $serviceOrder);
                    $this->sendSmsOnProcessingOrder($auth, $serviceOrder);
                }
            }
        });
    }

    /**
     * @param Authentication $auth
     * @param                $order
     */
    private function sendMailOnProcessingOrder(Authentication $auth, $order)
    {
        $user = $this->user($auth);

        $type = $order->product ? 'product' : 'service';
        $orderAdminUrl = route('admin.village.'.$type.'order.show', [$order->id]);
        $toEmails = [];

        if ($order->village->mainAdmin && @$user->village->mainAdmin->email) {
            $toEmails[] = $user->village->mainAdmin->email;
        }

        $executors = [];

        $entity = $order->{$type};
        // Для услуг
        if ($entity instanceof Service && $entity->executors) {
            foreach ($entity->executors->all() as $executor) {
                $executors[] = $executor->user;
            }
        }

        // Для товаров
        if ($entity instanceof Product && $entity->executor) {
            $executors[] = $entity->executor;
        }

        foreach ($executors as $executor) {
            if ($executor && $executor->email) {
                $toEmails[] = $executor->email;
            }
        }

        $data = [
            'adminUrl'  => $orderAdminUrl,
            'user'      => $user,
            'order'     => $order,
            'type'      => $type,
            'entity'    => $entity,
            'executors' => $executors,
        ];

        Mail::queue('village::emails.new-order', ['data' => $data],
            function (Message $m) use ($toEmails, $order){
                $toEmails = array_map('trim', $toEmails);
                $m
                    ->to($toEmails)
                    ->subject('Новый заказ в поселке '.$order->village->name.' '.$order->created_at->format('d-m-Y H:i:s').'.')
                ;
            }
        );
    }

    /**
     * @param Authentication $auth
     * @param                $order
     */
    private function sendSmsOnProcessingOrder(Authentication $auth, $order)
    {
        $user = $this->user($auth);

        if (!config('village.sms.enabled.on_order_processing')) {
            return;
        }

        $type = $order->product ? 'product' : 'service';
        $format = 'village.name;order.perform_date;order.perform_time;service.name;order.price;order.comment;order.payment_type;user.full_name;user.building.address;user.phone';
        $text = strtr($format, [
            'village.name' => $order->village->name,
            'order.perform_date' => $order->perform_date->format('d-m-Y'),
            'order.perform_time' => $order->perform_time,
            'service.name' => @$order->{$type}->title,
            'order.comment' => @$order->comment,
            'order.payment_type' => @$order->payment_type,
            'user.full_name' => @$order->user->present()->fullname(),
            'user.building.address' => @$order->user->building->address,
            'user.phone' => @$order->user->phone,
        ]);
        if ('product' === $type) {
            $text = strtr($text, [
                'order.price' => $order->unit_price.'x'.$order->quantity.'='.$order->price,
            ]);
        }
        else {
            $text = strtr($text, [
                'order.price;' => '',
            ]);
        }

        if ($order->village->send_sms_to_village_admin && $order->village->mainAdmin && $user->village->mainAdmin->phone) {
            $sms = new Sms();
            $sms->village()
                ->associate($user->village)
            ;
            $sms
                ->setPhone($user->village->mainAdmin->phone)
                ->setText($text)
//                ->setSender($user->village->name)
            ;

            try {
                smsGate()->send($sms);
            }
            catch (\Exception $ex) {
            }
        }

        if ($order->village->send_sms_to_executor) {
            $executors = [];

            // Для услуг
            if (@$order->{$type}->executors) {
                $executors = @$order->{$type}->executors->all();
            }

            // Для товаров
            if (@$order->{$type}->executor) {
                $executors[] = $order->{$type}->executor;
            }

            /** @var User $executor */
            foreach ($executors as $executor) {
                $sms = new Sms();
                $sms->village()
                    ->associate($executor->user->village)
                ;
                $sms
                    ->setPhone($executor->user->phone)
                    ->setText($text)
//                ->setSender($executor->user->village->name)
                ;
                try {
                    smsGate()->send($sms);
                }
                catch (\Exception $ex) {
                }
            }
        }
    }

    private function user(Authentication $auth)
    {
        if ($user = $auth->check()) {
            return $user;
        }
        else {
            try {

                $auth = \JWTAuth::parseToken();
                return $auth->authenticate();
            }
            catch (\Exception $ex) {
            }
        }

        return false;
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
            'Modules\Village\Repositories\BaseArticleRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentBaseArticleRepository(new \Modules\Village\Entities\BaseArticle());
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
            'Modules\Village\Repositories\BaseProductRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentBaseProductRepository(new \Modules\Village\Entities\BaseProduct());
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
            'Modules\Village\Repositories\BaseServiceRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentBaseServiceRepository(new \Modules\Village\Entities\BaseService());
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
            'Modules\Village\Repositories\ServiceExecutorRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentServiceExecutorRepository(new \Modules\Village\Entities\ServiceExecutor());
            }
        );
        $this->app->bind(
            'Modules\Village\Repositories\BaseSurveyRepository',
            function () {
                return new \Modules\Village\Repositories\Eloquent\EloquentBaseSurveyRepository(new \Modules\Village\Entities\BaseSurvey());
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
