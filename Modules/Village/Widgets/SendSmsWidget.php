<?php

namespace Modules\Village\Widgets;

use Modules\Core\Contracts\Authentication;
use Modules\Dashboard\Foundation\Widgets\BaseWidget;
use Modules\Village\Repositories\ServiceOrderChangeRepository;
use Modules\Village\Repositories\SmsRepository;

class SendSmsWidget extends BaseWidget
{
    /**
     * @var Authentication
     */
    private $auth;
    /**
     * @var ServiceOrderChangeRepository
     */
    private $smsRepository;

    /**
     * @param SmsRepository $smsRepository
     */
    public function __construct(SmsRepository $smsRepository, Authentication $auth)
    {
        $this->auth = $auth;
        $this->smsRepository = $smsRepository;
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
        return 'village::admin.sms.widgets.send';
    }
    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data()
    {
        return [
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
            'width' => '12',
            'height' => '2',
            'x' => '0',
            'y' => '0',
        ];
    }
}