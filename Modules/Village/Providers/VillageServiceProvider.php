<?php namespace Modules\Village\Providers;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Contracts\Authentication;
use Modules\Village\Entities\Article;
use Modules\Village\Entities\BaseArticle;
use Modules\Village\Entities\BaseProduct;
use Modules\Village\Entities\BaseService;
use Modules\Village\Entities\BaseSurvey;
use Modules\Village\Entities\Document;
use Modules\Village\Entities\OrderInterface;
use Modules\Village\Entities\Product;
use Modules\Village\Entities\ProductOrder;
use Modules\Village\Entities\ProductOrderChange;
use Modules\Village\Entities\Service;
use Modules\Village\Entities\ServiceOrder;
use Modules\Village\Entities\ServiceOrderChange;
use Modules\Village\Entities\Sms;
use Modules\Village\Entities\Survey;
use Modules\Village\Entities\User;
use Modules\Village\Entities\Village;
use Modules\Village\Jobs\SendArticleNotifications;
use Modules\Village\Jobs\SendDocumentNotifications;
use Modules\Village\Services\SentryPaymentGateway;
use PushNotification;


class VillageServiceProvider extends ServiceProvider
{
    use DispatchesJobs;
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
        ProductOrder::created(function (ProductOrder $productOrder) {
            if ($productOrder::PAYMENT_TYPE_CARD === $productOrder->payment_type) {
                if ($productOrder->product->has_card_payment) {
                    $payment = new SentryPaymentGateway();
                    $orderId = $productOrder->getOrderNameForCardPayment();

                    try {
                        $transactionId = $payment
                          ->generateTransaction(
                            $orderId,
                            $productOrder->price,
                            route('sentry.payment.process', [], true)
                          );

                        $productOrder->transaction_id = $transactionId;
                        $productOrder->save();
                    } catch (\Exception $ex) {
                        $productOrder->status         = $productOrder::STATUS_REJECTED;
                        $productOrder->decline_reason = $ex->getMessage();
                        $productOrder->save();
                    }
                } else {
                    $productOrder->payment_type = $productOrder::PAYMENT_TYPE_CASH;
                    $productOrder->save();
                }
            }
        }, -1);

        ProductOrder::saved(function (ProductOrder $productOrder) use ($auth) {
            if ($productOrder->isDirty('status')) {
                $user = $this->user($auth);

                ProductOrderChange::create([
                  'order_id'    => $productOrder->id,
                  'user_id'     => $user ? $user->id : null,
                  'from_status' => @$productOrder->getOriginal()['status'],
                  'to_status'   => $productOrder->status,
                ]);

                //  Send notification to admins, manages and executors
                //  on certain status changes.
                $managerNotifyStatuses = $productOrder::getManagerNotifyStatuses();
                if (in_array($productOrder->status, $managerNotifyStatuses)) {
                    $this->sendMailOnProcessingOrder($auth, $productOrder);
                    $this->sendSmsOnProcessingOrder($auth, $productOrder);
                }
                //  Send notification to client on certain status changes.
                $clientNotifyStatuses = $productOrder::getClientNotifyStatuses();
                if (in_array($productOrder->status, $clientNotifyStatuses)) {
                    $this->sendClientMailOnStatusChange($auth, $productOrder);
                    $this->sendClientSmsOnStatusChange($auth, $productOrder);
                    $this->sendClientPushOnStatusChange($auth, $productOrder);
                }
            }
        });

        ServiceOrder::created(function (ServiceOrder $serviceOrder) {
            if ($serviceOrder::PAYMENT_TYPE_CARD === $serviceOrder->payment_type) {
                if ($serviceOrder->service->has_card_payment) {
                    $payment = new SentryPaymentGateway();
                    $orderId = $serviceOrder->getOrderNameForCardPayment();

                    try {
                        $transactionId = $payment
                          ->generateTransaction(
                            $orderId,
                            $serviceOrder->price,
                            route('sentry.payment.process', [], true)
                          );

                        $serviceOrder->transaction_id = $transactionId;
                        $serviceOrder->save();
                    } catch (\Exception $ex) {
                        $serviceOrder->status         = $serviceOrder::STATUS_REJECTED;
                        $serviceOrder->decline_reason = $ex->getMessage();
                        $serviceOrder->save();
                    }
                } else {
                    $serviceOrder->payment_type = $serviceOrder::PAYMENT_TYPE_CASH;
                    $serviceOrder->save();
                }
            }
        });

        ServiceOrder::saved(function (ServiceOrder $serviceOrder) use ($auth) {
            if ($serviceOrder->isDirty('status')) {
                $user = $this->user($auth);

                ServiceOrderChange::create([
                  'order_id'    => $serviceOrder->id,
                  'user_id'     => $user ? $user->id : null,
                  'from_status' => @$serviceOrder->getOriginal()['status'],
                  'to_status'   => $serviceOrder->status,
                ]);

                //  Send notification to admins and executors
                //  on certain status changes.
                $managerNotifyStatuses = $serviceOrder::getManagerNotifyStatuses();
                if (in_array($serviceOrder->status, $managerNotifyStatuses)) {
                    $this->sendMailOnProcessingOrder($auth, $serviceOrder);
                    $this->sendSmsOnProcessingOrder($auth, $serviceOrder);
                }
                //  Send notification to client on certain status changes.

                $clientNotifyStatuses = $serviceOrder::getClientNotifyStatuses();
                if (in_array($serviceOrder->status, $clientNotifyStatuses)) {
                    $this->sendClientMailOnStatusChange($auth, $serviceOrder);
                    $this->sendClientSmsOnStatusChange($auth, $serviceOrder);
                    $this->sendClientPushOnStatusChange($auth, $serviceOrder);
                }

            }
        });
        // Create a queue job for sending push-notifications about important and personal articles.
        Article::saved(function (Article $article) use ($auth) {
            if ($article->active && ($article->is_important || $article->is_personal) && (strtotime($article->published_at) < time())) {
                $this->dispatch(new SendArticleNotifications($article));
            }
        });
        // Create a queue job for sending push-notifications about personal documents.
        Document::saved(function (Document $document) use ($auth) {
            if ($document->active && $document->is_personal && (strtotime($document->published_at) < time())) {
                $this->dispatch(new SendDocumentNotifications($document));
            }
        });

        // Create basic content for registered facility.
        Village::created(function (Village $village) {
            $baseArticles = (new BaseArticle())->where('is_'.$village->type, 1)->get();
            $publishedDate = (new Carbon())->format('Y-m-d H:i:00');
            $articles = [];
            foreach ($baseArticles as $baseArticle) {
                $article = new Article();
                $article->title = $baseArticle->title;
                $article->text = $baseArticle->text;
                $article->short = $baseArticle->short;
                $article->active = 1;
                $article->published_at = $article->created_at = $article->updated_at = $publishedDate;
                $article->village()->associate($village->id);
                $article->base()->associate($baseArticle->id);
                $articles[] = $article->toArray();
            }
            $baseServices = (new BaseService())->where('is_'.$village->type, 1)->get();
            $services = [];
            foreach ($baseServices as $baseService) {
                $service = new Service();
                $service->title = $baseService->title;
                $service->text = $baseService->text;
                $service->price = $baseService->price;
                $service->comment_label = $baseService->comment_label;
                $service->order_button_label = $baseService->order_button_label;
                $service->show_perform_time = $baseService->show_perform_time;
                $service->has_card_payment = $baseService->has_card_payment;
                $service->created_at = $service->updated_at = $publishedDate;
                $service->active = 1;
                $service->village()->associate($village->id);
                $service->category()->associate($baseService->category->id);
                $services[] = $service->toArray();
            }
            $baseProducts = (new BaseProduct())->where('is_'.$village->type, 1)->get();
            $products = [];
            foreach ($baseProducts as $baseProduct) {
                $product = new Product();
                $product->title = $baseProduct->title;
                $product->price = $baseProduct->price;
                $product->unit_title = $baseProduct->unit_title;
                $product->comment_label = $baseProduct->comment_label;
                $product->show_perform_time = $baseProduct->show_perform_time;
                $product->has_card_payment = $baseProduct->has_card_payment;
                $product->created_at = $service->updated_at = $publishedDate;
                $product->active = 1;
                $product->village()->associate($village->id);
                $product->category()->associate($baseProduct->category->id);
                $products[] = $product->toArray();
            }
            $baseSurveys = (new BaseSurvey())->where('is_'.$village->type, 1)->get();
            $surveys = [];
            foreach ($baseSurveys as $baseSurvey) {
                $survey = new Survey();
                $survey->title = $baseSurvey->title;
                $survey->active = 1;
                $survey->options = $baseSurvey->options;
                $survey->created_at = $survey->updated_at = $publishedDate;
                $survey->ends_at = (new Carbon())->addDays(30)->format('Y-m-d');
                $survey->village()->associate($village->id);
                $surveys[] = $survey->toArray();
            }
            $document = new Document();
            $document->title = 'Тестовый документ';
            $document->village()->associate($village->id);
            $document->published_at = $publishedDate;
            $document->active = 1;
            \DB::transaction(function () use ($articles, $products, $surveys, $services, $document) {
                if (count($articles)) {
                    \DB::table('village__articles')->insert($articles);
                }
                if (count($products)) {
                    \DB::table('village__products')->insert($products);
                }
                if (count($surveys)) {
                    \DB::table('village__surveys')->insert($surveys);
                }
                if (count($services)) {
                    \DB::table('village__services')->insert($services);
                }
                $document->save();
            });
        });
    }

    private function getStatusText(OrderInterface $order)
    {
        $statusTexts = array(
          $order::STATUS_DONE       => 'выполнен',
          $order::STATUS_RUNNING    => 'обрабатывается',
          $order::STATUS_PROCESSING => 'был принят в работу',
          $order::STATUS_REJECTED   => 'отклонен',
        );
        $statusText  = $statusTexts[$order->status];
        if ($order::STATUS_REJECTED == $order->status && $order->decline_reason) {
            $statusText .= ' (' . $order->decline_reason . ')';
        }
        return $statusText;
    }

    /**
     * @param Authentication $auth
     * @param OrderInterface $order
     */
    private function sendClientPushOnStatusChange(Authentication $auth, OrderInterface $order)
    {
        $devices = $order->user->devices;
        $orderType = $order->getOrderType();
        $messageText = date('H:i'). ': ';
        $messageText .= 'заказ  №'.$order->id.':'.PHP_EOL;
        $messageText .= '"'.$order->$orderType->title.'" '.$this->getStatusText($order).'.';
        // Push notification with custom link inside app.
        $message = PushNotification::Message($messageText, array(
          'category' => '/profile/history?type='.$orderType
        ));
        foreach ($devices as $device) {
            PushNotification::app($device->type)
                            ->to($device->token)
                            ->send($message);
        }
    }

    /**
     * @param Authentication $auth
     * @param OrderInterface $order
     */
    private function sendClientSmsOnStatusChange(Authentication $auth, OrderInterface $order)
    {

        $user = $this->user($auth);
        if (!config('village.sms.enabled.on_order_processing_user') || !$order->user->has_sms_notifications) {
            return;
        }

        if ($userMail = $order->user->phone) {
            $type = $order->product ? 'product' : 'service';
            // TODO get format.
            //$format = 'user.full_name;order.completed;village.name;service.name;';
            $format     = 'order.completed;village.name;service.name;';
            $statusText = ' ' . $this->getStatusText($order);
            $text       = strtr($format, [
                // 'user.full_name'        => 'Уважаемый, '.@$order->user->present()->fullname(),
              'order.completed' => 'Ваш заказ №' . @$order->id . $statusText,
              'village.name'    => @$order->village->name,
              'service.name'    => @$order->{$type}->title
            ]);
            $sms        = new Sms();
            $sms->village()
                ->associate($order->user->village);
            $sms
              ->setPhone($order->user->phone)
              ->setText($text);

            try {
                smsGate()->send($sms);
            } catch (\Exception $ex) {
            }
        }
    }

    /**
     * @param Authentication $auth
     * @param OrderInterface $order
     */
    private function sendClientMailOnStatusChange(Authentication $auth, OrderInterface $order)
    {
        if (!config('village.order.on_order_processing_send_client_mail') || !$order->user->has_mail_notifications) {
            return;
        }

        $user       = $this->user($auth);
        $type       = $order->product ? 'product' : 'service';
        $toEmails   = [];
        $statusText = ' ' . $this->getStatusText($order);
        if ($userMail = $order->user->email) {
            $toEmails[] = $userMail;
            $executors  = [];
            $entity     = $order->{$type};
            $data       = [
              'user'      => $user,
              'order'     => $order,
              'type'      => $type,
              'status'    => $statusText,
              'entity'    => $entity,
              'executors' => $executors,
            ];
            Mail::queue('village::emails.user-order', ['data' => $data],
              function (Message $m) use ($toEmails, $order) {
                  $toEmails = array_map('trim', $toEmails);
                  $m
                    ->to($toEmails)
                    ->subject('Ваш заказ №' . $order->id . ' был обновлен.');
              }
            );
        }
    }

    /**
     * @param Authentication $auth
     * @param OrderInterface $order
     */
    private function sendMailOnProcessingOrder(Authentication $auth, OrderInterface $order)
    {
        $user = $this->user($auth);

        $type          = $order->product ? 'product' : 'service';
        $orderAdminUrl = route('admin.village.' . $type . 'order.show', [$order->id]);
        $toEmails      = [];

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
          function (Message $m) use ($toEmails, $order) {
              $toEmails = array_map('trim', $toEmails);
              $m
                ->to($toEmails)
                ->subject('Новый заказ - ' . $order->village->name . ' ' . $order->created_at->format('d-m-Y H:i:s') . '.');
          }
        );
    }

    /**
     * @param Authentication $auth
     * @param OrderInterface $order
     */
    private function sendSmsOnProcessingOrder(Authentication $auth, OrderInterface $order)
    {
        $user = $this->user($auth);

        if (!config('village.sms.enabled.on_order_processing')) {
            return;
        }

        $type   = $order->product ? 'product' : 'service';
        $format = 'village.name;order.perform_date;order.perform_time;service.name;order.price;order.comment;order.payment_type;user.full_name;user.building.address;user.phone';
        $text   = strtr($format, [
          'village.name'          => $order->village->name,
          'order.perform_date'    => $order->perform_date->format('d-m-Y'),
          'order.perform_time'    => $order->perform_time,
          'service.name'          => @$order->{$type}->title,
          'order.comment'         => @$order->comment,
          'order.payment_type'    => @$order->payment_type,
          'user.full_name'        => @$order->user->present()->fullname(),
          'user.building.address' => @$order->user->building->address,
          'user.phone'            => @$order->user->phone,
        ]);
        if ('product' === $type) {
            $text = strtr($text, [
              'order.price' => $order->unit_price . 'x' . $order->quantity . '=' . $order->price,
            ]);
        } else {
            $text = strtr($text, [
              'order.price;' => '',
            ]);
        }

        if ($order->village->send_sms_to_village_admin && $order->village->mainAdmin && $user->village->mainAdmin->phone) {
            $sms = new Sms();
            $sms->village()
                ->associate($user->village);
            $sms
              ->setPhone($user->village->mainAdmin->phone)
              ->setText($text)//                ->setSender($user->village->name)
            ;

            try {
                smsGate()->send($sms);
            } catch (\Exception $ex) {
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
                    ->associate($executor->user->village);
                $sms
                  ->setPhone($executor->user->phone)
                  ->setText($text)//                ->setSender($executor->user->village->name)
                ;
                try {
                    smsGate()->send($sms);
                } catch (\Exception $ex) {
                }
            }
        }
    }

    private function user(Authentication $auth)
    {
        if ($user = $auth->check()) {
            return $user;
        } else {
            try {

                $auth = \JWTAuth::parseToken();
                return $auth->authenticate();
            } catch (\Exception $ex) {
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
          'Modules\Village\Repositories\DocumentCategoryRepository',
          function () {
              return new \Modules\Village\Repositories\Eloquent\EloquentDocumentCategoryRepository(new \Modules\Village\Entities\DocumentCategory());
          }
        );
        $this->app->bind(
          'Modules\Village\Repositories\DocumentRepository',
          function () {
              return new \Modules\Village\Repositories\Eloquent\EloquentDocumentRepository(new \Modules\Village\Entities\Document());
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
          'Modules\Village\Repositories\ArticleCategoryRepository',
          function () {
              return new \Modules\Village\Repositories\Eloquent\EloquentArticleCategoryRepository(new \Modules\Village\Entities\ArticleCategory());
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
