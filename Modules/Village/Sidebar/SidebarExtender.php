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
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('village::abcs.title.abcs'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('village::articles.title.articles'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.village.article.create');
                    $item->route('admin.village.article.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.articles.index')
                    );
                });
                $item->item(trans('village::buildings.title.buildings'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.village.building.create');
                    $item->route('admin.village.building.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.buildings.index')
                    );
                });
                $item->item(trans('village::options.title.options'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.village.option.create');
                    $item->route('admin.village.option.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.options.index')
                    );
                });
                $item->item(trans('village::products.title.products'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.village.product.create');
                    $item->route('admin.village.product.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.products.index')
                    );
                });
                $item->item(trans('village::productcategories.title.productcategories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.village.productcategory.create');
                    $item->route('admin.village.productcategory.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.productcategories.index')
                    );
                });
                $item->item(trans('village::productorders.title.productorders'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.village.productorder.create');
                    $item->route('admin.village.productorder.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.productorders.index')
                    );
                });
                $item->item(trans('village::services.title.services'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.village.service.create');
                    $item->route('admin.village.service.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.services.index')
                    );
                });
                $item->item(trans('village::servicecategories.title.servicecategories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.village.servicecategory.create');
                    $item->route('admin.village.servicecategory.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.servicecategories.index')
                    );
                });
                $item->item(trans('village::serviceorders.title.serviceorders'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.village.serviceorder.create');
                    $item->route('admin.village.serviceorder.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.serviceorders.index')
                    );
                });
                $item->item(trans('village::surveys.title.surveys'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.village.survey.create');
                    $item->route('admin.village.survey.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.surveys.index')
                    );
                });
                $item->item(trans('village::surveyvotes.title.surveyvotes'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.village.surveyvote.create');
                    $item->route('admin.village.surveyvote.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.surveyvotes.index')
                    );
                });
                $item->item(trans('village::tokens.title.tokens'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.village.token.create');
                    $item->route('admin.village.token.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.tokens.index')
                    );
                });
                $item->item(trans('village::margins.title.margins'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.village.margin.create');
                    $item->route('admin.village.margin.index');
                    $item->authorize(
                        $this->auth->hasAccess('village.margins.index')
                    );
                });
// append













            });
        });

        return $menu;
    }
}
