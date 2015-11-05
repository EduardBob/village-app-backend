<?php

namespace Modules\Village\Widgets;

use Modules\Core\Contracts\Authentication;
use Modules\Dashboard\Foundation\Widgets\BaseWidget;
use Modules\Village\Repositories\ProductOrderChangeRepository;

class LatestProductOrderChangesWidget extends BaseWidget
{
    /**
     * @var Authentication
     */
    private $auth;
    /**
     * @var ProductOrderChangeRepository
     */
    private $changes;

    /**
     * @param ProductOrderChangeRepository $changes
     */
    public function __construct(ProductOrderChangeRepository $changes, Authentication $auth)
    {
        $this->auth = $auth;
        $this->changes = $changes;
    }
    /**
     * Get the widget name
     * @return string
     */
    protected function name()
    {
        return 'LatestProductOrderChangesWidget';
    }
    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'village::admin.productorderchanges.widgets.latest';
    }
    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data()
    {
        return [
            'collection' => $this->changes->latest(10),
            'currentUser' => $this->auth->check(),
        ];
    }
    /**
     * Get the widget type
     * @return string
     */
    protected function options()
    {
        return [
            'width' => '6',
            'height' => '15',
            'x' => '0',
        ];
    }
}