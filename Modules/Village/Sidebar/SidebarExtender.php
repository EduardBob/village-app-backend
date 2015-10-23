<?php namespace Modules\Village\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Contracts\Authentication;

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
        $menu->group(trans('village::village.title'), function (Group $group) {
            $group->item(trans('village::villages.title.module'), function (Item $item) {
                $item->icon('fa fa-home');
                $item->weight(0);
                if ($this->auth->check()->hasAccess('village.villages.create')) {
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
                if ($this->auth->check()->hasAccess('village.buildings.create')) {
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

                $item->item(trans('village::productorders.title.module'), function (Item $item) {
                    $item->icon('fa fa-shopping-cart');
                    $item->weight(5);
                    if ($this->auth->check()->hasAccess('village.productorders.create')) {
                        $item->append('admin.village.productorder.create');
                    }
                    $item->route('admin.village.productorder.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.productorders.index')
                    );
                });

                $item->item(trans('village::products.title.module'), function (Item $item) {
                    $item->icon('fa fa-cube');
                    $item->weight(5);
                    if ($this->auth->check()->hasAccess('village.products.create')) {
                        $item->append('admin.village.product.create');
                    }
                    $item->route('admin.village.product.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.products.index')
                    );
                });

                $item->item(trans('village::productcategories.title.module'), function (Item $item) {
                    $item->icon('fa fa-list');
                    $item->weight(5);
                    if ($this->auth->check()->hasAccess('village.productcategories.create')) {
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

                $item->item(trans('village::serviceorders.title.module'), function (Item $item) {
                    $item->icon('fa fa-shopping-cart');
                    $item->weight(5);
                    if ($this->auth->check()->hasAccess('village.serviceorders.create')) {
                        $item->append('admin.village.serviceorder.create');
                    }
                    $item->route('admin.village.serviceorder.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.serviceorders.index')
                    );
                });

                $item->item(trans('village::services.title.module'), function(Item $item) {
                    $item->icon('fa fa-cube');
                    $item->weight(5);
                    if ($this->auth->check()->hasAccess('village.services.create')) {
                        $item->append('admin.village.service.create');
                    }
                    $item->route('admin.village.service.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.services.index')
                    );
                });

                $item->item(trans('village::servicecategories.title.module'), function (Item $item) {
                    $item->icon('fa fa-list');
                    $item->weight(5);
                    if ($this->auth->check()->hasAccess('village.servicecategories.create')) {
                        $item->append('admin.village.servicecategory.create');
                    }
                    $item->route('admin.village.servicecategory.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.servicecategories.index')
                    );
                });
            });

            $group->item(trans('village::margins.title.module'), function (Item $item) {
                $item->icon('fa fa-money');
                $item->weight(3);
                if ($this->auth->check()->hasAccess('village.margins.create')) {
                    $item->append('admin.village.margin.create');
                }
                $item->route('admin.village.margin.index');
                $item->authorize(
                    $this->auth->hasAccess('village.margins.index')
                );
            });

            $group->item(trans('village::articles.title.module'), function (Item $item) {
                $item->icon('fa fa-money');
                $item->weight(3);
                if ($this->auth->check()->hasAccess('village.articles.create')) {
                    $item->append('admin.village.article.create');
                }
                $item->route('admin.village.article.index');
                $item->authorize(
                    $this->auth->hasAccess('village.articles.index')
                );
            });

            $group->item(trans('village::surveys.title.module'), function (Item $item) {
                $item->icon('fa fa-list-alt');
                $item->weight(4);
                $item->authorize(
                    $this->auth->hasAccess('village.surveys.index')
                );

                $item->item(trans('village::surveyvotes.title.module'), function (Item $item) {
                    $item->icon('fa fa-list');
                    $item->weight(5);
                    if ($this->auth->check()->hasAccess('village.surveyvotes.create')) {
                        $item->append('admin.village.surveyvote.create');
                    }
                    $item->route('admin.village.surveyvote.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.surveyvotes.index')
                    );
                });

                $item->item(trans('village::surveys.title.module'), function (Item $item) {
                    $item->icon('fa fa-cube');
                    $item->weight(5);
                    if ($this->auth->check()->hasAccess('village.surveys.create')) {
                        $item->append('admin.village.survey.create');
                    }
                    $item->route('admin.village.survey.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.surveys.index')
                    );
                });
            });
        });

        return $menu;
    }
}
