<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\Sms;
use Modules\Village\Entities\User;
use Modules\Village\Entities\Village;
use Modules\Village\Repositories\SmsRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class SmsController extends AdminController
{
    /**
     * @param SmsRepository $sms
     */
    public function __construct(SmsRepository $sms)
    {
        parent::__construct($sms, Sms::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'sms';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__sms.id',
            'village__sms.village_id',
            'village__sms.text',
            'village__sms.created_at',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->join('village__villages', 'village__sms.village_id', '=', 'village__villages.id')
            ->with(['village'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__sms.village_id', $this->getCurrentUser()->village->id);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
            ->addColumn(['data' => 'id', 'name' => 'village__sms.id', 'title' => $this->trans('table.id')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')])
            ;
        }
        $builder
            ->addColumn(['data' => 'text', 'name' => 'village__sms.text', 'title' => $this->trans('table.text')])
            ->addColumn(['data' => 'created_at', 'name' => 'village__sms.created_at', 'title' => $this->trans('table.created_at')])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->editColumn('village_name', function (Sms $sms) {
                    if ($this->getCurrentUser()->hasAccess('village.villages.edit')) {
                        return '<a href="'.route('admin.village.village.edit', ['id' => $sms->village->id]).'">'.$sms->village->name.'</a>';
                    }
                    else {
                        return $sms->village->name;
                    }
                })
            ;
        }

        $dataTable
            ->addColumn('created_at', function (Sms $sms) {
                return localizeddate($sms->created_at);
            })
        ;
    }

    /**
     * @param array   $data
     * @param Sms $sms
     *
     * @return Validator
     */
    public function validate(array $data, Sms $sms = null)
    {
        $rules = [
            'text' => "required|max:255",
            'active' => "required|boolean",
        ];

        if ($this->getCurrentUser()->inRole('admin')) {
            $rules['village_id'] = 'required|exists:village__villages,id';
        }

        return Validator::make($data, $rules);
    }

    /**
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Request $request)
    {
        $village = Village::find((int)$request->get('village_id'));
        $text = trim($request->get('text'));

        if (!$text) {
            flash()->error(trans('village::sms.messages.sent validation error'));

            return redirect()->route('dashboard.index');
        }

        $query = $village ? User::with(['village'])->where('village_id', $village->id) : new User();

        $users = $query
            ->leftJoin('activations', 'activations.user_id', '=', 'users.id')
            ->where('activations.completed', 1)
            ->get()
        ;

        if (!$users->count()) {
            flash()->warning(trans('village::sms.messages.sent no one'));

            return redirect()->route('dashboard.index');
        }

        if (config('village.sms.enabled.mass')) {
            $smsCollection = [];
            foreach ($users as $user) {
                // Только если указан объект
                if (!$user->village->id) {
                    continue;
                }

                $sms = new Sms();
                $sms->village()->associate($user->village);
                $sms
                    ->setText($text)
                    ->setPhone($user->phone)
//                    ->setSender($user->village->name)
                ;
                $smsCollection[] = $sms;
            }

            $smsCollection = Sms::sendQueue($smsCollection);

            $count = ['success' => 0, 'error' => 0];
            /** @var Sms $sms */
            foreach ($smsCollection as $sms) {
                $sms->getStatus() == $sms::STATUS_ACCEPTED ? $count['success']++ : $count['error']++;
            }

            flash()->warning(trans('village::sms.messages.sent all', ['total' => count($smsCollection), 'success' => $count['success'], 'error' => $count['error']]));
        }
        else {
            flash()->warning(trans('village::sms.messages.send mass disabled'));
        }

        return redirect()->route('dashboard.index');
    }
}
