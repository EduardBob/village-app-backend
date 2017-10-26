<?php namespace Modules\Village\Sidebar;

use Maatwebsite\Sidebar\Badge;
use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Contracts\Authentication;
use Modules\Village\Repositories\ProductOrderRepository;
use Modules\Village\Repositories\ServiceOrderRepository;
use Carbon\Carbon;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $user = $this->auth->check();
       if($user) {
           $village = $user->village;
           $villageTitle = trans('village::village.title');
           if ($user->inRole('village-admin') && !$village->is_unlimited) {
               if($village->active) {
                   $villageTitle .= ' ' . trans('village::villages.packet.active_to') . ' ' . (new Carbon($village->payed_until))->format(config('village.date.human.shorter'));
               }
               else{
                   $villageTitle .= ' ' . trans('village::villages.packet.not_active');
               }
           }
           $menu->group($villageTitle, function (Group $group) use ($user, $village) {
               if ($user->inRole('village-admin') && !$village->is_unlimited) {
                   $group->item( trans('village::villages.packet.balance'), function (Item $item) use ($user, $village) {
                       $item->icon('fa fa-dollar');
                       $item->weight(-1);
                       $item->route('dashboard.index');
                       $packet = $village->getCurrentPacket();
                       $badgeClass = 'bg-red';
                       if($packet['balance'] >= $packet['price'])
                       {
                           $badgeClass = 'bg-green';
                       }
                       $item->badge($village->balance . ' '. trans('village::villages.packet.money'), $badgeClass);
                   });
               }
               $group->item(trans('village::villages.title.module'), function (Item $item) {
                   $item->icon('fa fa-home');
                   $item->weight(0);
                   if ($this->auth->hasAccess('village.villages.create')) {
                       $item->append('admin.village.village.create');
                   }
                   $item->route('admin.village.village.index');
                   $item->authorize(
                     $this->auth->hasAccess('village.villages.index')
                   );
               });

               $group->item(trans('village::buildings.title.module'), function (Item $item) {
                   $item->icon('fa fa-home');
                   $item->weight(0);
                   if ($this->auth->hasAccess('village.buildings.create')) {
                       $item->append('admin.village.building.create');
                   }
                   $item->route('admin.village.building.index');
                   $item->authorize(
                     $this->auth->hasAccess('village.buildings.index')
                   );
               });

               $group->item(trans('village::products.title.module'), function (Item $item) {
                   $item->icon('fa fa-list-alt');
                   $item->weight(1);
                   $item->authorize(
                     $this->auth->hasAccess('village.products.index')
                   );

                   $item->item(trans('village::baseproducts.title.module'), function (Item $item) {
                       $item->icon('fa fa-cube');
                       $item->weight(1);
                       if ($this->auth->hasAccess('village.baseproducts.create')) {
                           $item->append('admin.village.baseproduct.create');
                       }
                       $item->route('admin.village.baseproduct.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.baseproducts.index')
                       );
                   });

                   $item->item(trans('village::products.title.module'), function (Item $item) {
                       $item->icon('fa fa-cube');
                       $item->weight(2);

                       if ($this->auth->hasAccess('village.products.create')) {
                           $item->append('admin.village.product.create');
                       }
                       $item->route('admin.village.product.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.products.index')
                       );
                   });

                   $item->item(trans('village::productcategories.title.module'), function (Item $item) {
                       $item->icon('fa fa-list');
                       $item->weight(3);
                       if ($this->auth->hasAccess('village.productcategories.create')) {
                           $item->append('admin.village.productcategory.create');
                       }
                       $item->route('admin.village.productcategory.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.productcategories.index')
                       );
                   });
               });

               $group->item(trans('village::services.title.module'), function (Item $item) {
                   $item->icon('fa fa-list-alt');
                   $item->weight(2);
                   $item->authorize(
                     $this->auth->hasAccess('village.services.index')
                   );

                   $item->item(trans('village::baseservices.title.module'), function (Item $item) {
                       $item->icon('fa fa-cube');
                       $item->weight(1);
                       if ($this->auth->hasAccess('village.baseservices.create')) {
                           $item->append('admin.village.baseservice.create');
                       }
                       $item->route('admin.village.baseservice.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.baseservices.index')
                       );
                   });

                   $item->item(trans('village::services.title.module'), function (Item $item) {
                       $item->icon('fa fa-cube');
                       $item->weight(2);
//                    if ($this->auth->hasAccess('village.services.create')) {
//                        $item->append('admin.village.service.create');
//                    }
                       $item->route('admin.village.service.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.services.index')
                       );
                   });

                   $item->item(trans('village::servicecategories.title.module'), function (Item $item) {
                       $item->icon('fa fa-list');
                       $item->weight(3);
                       if ($this->auth->hasAccess('village.servicecategories.create')) {
                           $item->append('admin.village.servicecategory.create');
                       }
                       $item->route('admin.village.servicecategory.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.servicecategories.index')
                       );
                   });
               });

               $group->item(trans('village::admin.title.orders'), function (Item $item) {
                   $item->icon('fa fa-shopping-cart');
                   $item->weight(11);


                   $item->item(trans('village::productorders.title.module'), function (Item $item) {
                       $item->icon('fa fa-shopping-cart');
//                    if ($this->auth->hasAccess('village.productorders.create')) {
//                        $item->append('admin.village.productorder.create');
//                    }
                       $item->route('admin.village.productorder.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.productorders.index')
                       );
                       $item->badge(function (Badge $badge, ProductOrderRepository $productOrderRepository) {
                           $count = $this->getProductOrderBadgeCount($productOrderRepository);
                           if ($count > 0) {
                               $badge
                                 ->setClass('bg-blue')
                                 ->setValue($count);
                           }
                       });
                   });
                   $item->item(trans('village::serviceorders.title.module'), function (Item $item) {
                       $item->icon('fa fa-shopping-cart');
//                    if ($this->auth->hasAccess('village.serviceorders.create')) {
//                        $item->append('admin.village.serviceorder.create');
//                    }
                       $item->route('admin.village.serviceorder.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.serviceorders.index')
                       );
                       $item->badge(function (Badge $badge, ServiceOrderRepository $serviceOrderRepository) {
                           $count = $this->getServiceOrderBadgeCount($serviceOrderRepository);
                           if ($count > 0) {
                               $badge
                                 ->setClass('bg-blue')
                                 ->setValue($count);
                           }
                       });
                   });

                   $item->item(trans('village::serviceorderssc.title.module'), function (Item $item) {
                       $item->weight(2);
                       $item->icon('fa fa-shopping-cart');
                       $item->route('admin.village.serviceordersc.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.serviceorderssc.index')
                       );
                   });

                   $item->item(trans('village::serviceordersscnew.title.module'), function (Item $item) {
                       $item->weight(2);
                       $item->icon('fa fa-shopping-cart');
                       $item->route('admin.village.serviceorderscnew.index');
                       $item->authorize(
                           $this->auth->hasAccess('village.serviceordersscnew.index')
                       );
                   });

                   if ($this->auth->hasAccess('village.productorderchanges.index')) {
                       $item->item(trans('village::productorderchanges.title.module'), function (Item $item) {
                           $item->weight(3);
                           $item->icon('fa fa-shopping-cart');
                           $item->route('admin.village.productorderchange.index');
                           $item->authorize(
                             $this->auth->hasAccess('village.productorderchanges.index')
                           );
                       });
                   }

                   if ($this->auth->hasAccess('village.serviceorderchanges.index')) {
                       $item->item(trans('village::serviceorderchanges.title.module'), function (Item $item) {
                           $item->weight(4);
                           $item->icon('fa fa-shopping-cart');
                           $item->route('admin.village.serviceorderchange.index');
                           $item->authorize(
                             $this->auth->hasAccess('village.serviceorderchanges.index')
                           );
                       });
                   }
               });

               $group->item(trans('village::margins.title.module'), function (Item $item) {
                   $item->icon('fa fa-money');
                   $item->weight(4);
                   if ($this->auth->hasAccess('village.margins.create')) {
                       $item->append('admin.village.margin.create');
                   }
                   $item->route('admin.village.margin.index');
                   $item->authorize(
                     $this->auth->hasAccess('village.margins.index')
                   );
               });

               $group->item(trans('village::articles.title.module'), function (Item $item) {
                   $item->icon('fa fa-money');
                   $item->weight(5);

                   $item->authorize(
                     $this->auth->hasAccess('village.articles.index')
                   );

                   $item->item(trans('village::basearticles.title.module'), function (Item $item) {
                       $item->icon('fa fa-cube');
                       $item->weight(1);
                       if ($this->auth->hasAccess('village.basearticles.create')) {
                           $item->append('admin.village.basearticle.create');
                       }
                       $item->route('admin.village.basearticle.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.basearticles.index')
                       );
                   });

                   $item->item(trans('village::articles.title.module'), function (Item $item) {
                       $item->icon('fa fa-cube');
                       $item->weight(2);
                       if ($this->auth->hasAccess('village.articles.create')) {
                           $item->append('admin.village.article.create');
                       }
                       $item->route('admin.village.article.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.articles.index')
                       );
                   });

                   $item->item(trans('village::articlecategories.title.module'), function (Item $item) {
                       $item->icon('fa fa-list');
                       $item->weight(3);
                       if ($this->auth->hasAccess('village.articlecategories.create')) {
                           $item->append('admin.village.articlecategory.create');
                       }
                       $item->route('admin.village.articlecategory.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.articlecategories.index')
                       );
                   });
               });

               $group->item(trans('village::documents.title.module'), function (Item $item) {
                   $item->icon('fa fa-file');
                   $item->weight(20);
                   $item->authorize(
                     $this->auth->hasAccess('village.documents.index')
                   );
                   $item->item(trans('village::documents.title.module'), function (Item $item) {
                       $item->icon('fa fa-cube');
                       $item->weight(2);
                       if ($this->auth->hasAccess('village.documents.create')) {
                           $item->append('admin.village.document.create');
                       }
                       $item->route('admin.village.document.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.documents.index')
                       );
                   });
                   $item->item(trans('village::documentcategories.title.module'), function (Item $item) {
                       $item->icon('fa fa-list');
                       $item->weight(3);
                       if ($this->auth->hasAccess('village.documentcategories.create')) {
                           $item->append('admin.village.documentcategory.create');
                       }
                       $item->route('admin.village.documentcategory.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.documentcategories.index')
                       );
                   });
               });

               $group->item(trans('village::surveys.title.module'), function (Item $item) {
                   $item->icon('fa fa-list-alt');
                   $item->weight(6);
                   $item->authorize(
                     $this->auth->hasAccess('village.surveys.index')
                   );

                   $item->item(trans('village::basesurveys.title.module'), function (Item $item) {
                       $item->icon('fa fa-cube');
                       $item->weight(1);
                       if ($this->auth->hasAccess('village.basesurveys.create')) {
                           $item->append('admin.village.basesurvey.create');
                       }
                       $item->route('admin.village.basesurvey.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.basesurveys.index')
                       );
                   });

                   $item->item(trans('village::surveys.title.module'), function (Item $item) {
                       $item->icon('fa fa-cube');
                       $item->weight(2);
                       if ($this->auth->hasAccess('village.surveys.create')) {
                           $item->append('admin.village.survey.create');
                       }
                       $item->route('admin.village.survey.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.surveys.index')
                       );
                   });

                   $item->item(trans('village::surveyvotes.title.module'), function (Item $item) {
                       $item->icon('fa fa-list');
                       $item->weight(3);
                       if ($this->auth->hasAccess('village.surveyvotes.create')) {
                           $item->append('admin.village.surveyvote.create');
                       }
                       $item->route('admin.village.surveyvote.index');
                       $item->authorize(
                         $this->auth->hasAccess('village.surveyvotes.index')
                       );
                   });
               });
           });
       }
           return $menu;

    }

    /**
     * @param ProductOrderRepository $productOrderRepository
     */
    protected function getProductOrderBadgeCount(ProductOrderRepository $productOrderRepository)
    {
        $user = $this->auth->check();
        if (!$user) {
            return 0;
        }

        $village = null;
        $executor = null;
        if ($user->inRole('village-admin') || $user->inRole('nouser')) {
            $village = $user->village;
        }
        elseif ($user->inRole('executor')) {
            $village = $user->village;
            $executor = $user;
        }



        return $productOrderRepository->count($village, $executor);
    }

    /**
     * @param ServiceOrderRepository $serviceOrderRepository
     */
    protected function getServiceOrderBadgeCount(ServiceOrderRepository $serviceOrderRepository)
    {
        $user = $this->auth->check();
        if (!$user) {
            return 0;
        }

        $village = null;
        $executor = null;
        if ($user->inRole('village-admin') || $user->inRole('nouser')) {
            $village = $user->village;
        }
        elseif ($user->inRole('executor')) {
            $village = $user->village;
            $executor = $user;
        }

        return $serviceOrderRepository->count($village, $executor);
    }
}
