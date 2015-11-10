<?php

namespace Modules\Village\Widgets;

use Modules\Core\Contracts\Authentication;
use Modules\Dashboard\Foundation\Widgets\BaseWidget;
use Modules\Village\Repositories\ServiceOrderChangeRepository;

class LatestServiceOrderChangesWidget extends BaseWidget
{
    /**
     * @var Authentication
     */
    private $auth;
    /**
     * @var ServiceOrderChangeRepository
     */
    private $changes;

    /**
     * @param ServiceOrderChangeRepository $changes
     */
    public function __construct(ServiceOrderChangeRepository $changes, Authentication $auth)
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
        return get_class();
    }
    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'village::admin.serviceorderchanges.widgets.latest';
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
            'x' => '6',
            'y' => '2',
        ];
    }
}