<?php namespace Modules\Village\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;
use Modules\Village\Entities\AbstractOrder;
use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Village;
use Modules\Village\Repositories\AbstractOrderRepository;
use Modules\Village\Entities\Product;
use Modules\Village\Repositories\ProductRepository;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

abstract class AbstractOrderController extends AdminController
{
	/**
	 * @param int $id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function setStatusRunning($id)
	{
		/** @var AbstractOrder $abstractOrder */
		$abstractOrder = $this->repository->find((int)$id);
		if (!$abstractOrder || $abstractOrder->status !== $abstractOrder::STATUS_PROCESSING) {
			return redirect()->back(302);
		}
		$abstractOrder->status = $abstractOrder::STATUS_RUNNING;
		$abstractOrder->save();

		flash()->success($this->trans('messages.resource status-running'));

		return redirect()->back(302);
//		return redirect()->route($this->getRoute('index'));
	}

	/**
	 * @param int $id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function setStatusDone($id)
	{
		/** @var AbstractOrder $abstractOrder */
		$abstractOrder = $this->repository->find((int)$id);
		if (!$abstractOrder || $abstractOrder->status !== $abstractOrder::STATUS_RUNNING) {
			return redirect()->back(302);
		}

		$abstractOrder->status = $abstractOrder::STATUS_DONE;
		$abstractOrder->save();

		flash()->success($this->trans('messages.resource status-done'));

        return redirect()->back(302);
//		return redirect()->route($this->getRoute('index'));
	}

	/**
	 * @param int $id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function setPaymentDone($id)
	{
		/** @var AbstractOrder $abstractOrder */
		$abstractOrder = $this->repository->find((int)$id);
		if (!$abstractOrder || $abstractOrder->payment_status === $abstractOrder::PAYMENT_STATUS_PAID) {
			return redirect()->back(302);
		}

		$abstractOrder->payment_status = $abstractOrder::PAYMENT_STATUS_PAID;
		$abstractOrder->save();

		flash()->success($this->trans('messages.resource payment-done'));

		return redirect()->route($this->getRoute('index'));
	}

	/**
	 * @param int $id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function setPaymentAndStatusDone($id)
	{
		/** @var AbstractOrder $abstractOrder */
		$abstractOrder = $this->repository->find((int)$id);
		if (!$abstractOrder || $abstractOrder->status !== $abstractOrder::STATUS_RUNNING || $abstractOrder->status !== $abstractOrder::STATUS_RUNNING) {
			return redirect()->back(302);
		}

		$abstractOrder->payment_status = $abstractOrder::PAYMENT_STATUS_PAID;
		$abstractOrder->status = $abstractOrder::STATUS_DONE;
		$abstractOrder->save();

		flash()->success($this->trans('messages.resource payment-and-status-done'));

		return redirect()->route($this->getRoute('index'));
	}
	/**
	 * @param Model $model
	 *
	 * @return false|\Illuminate\Http\RedirectResponse
	 */
	public function checkPermissionDenied(Model $model)
	{
		$currentUser = $this->getCurrentUser();

		if (method_exists($model, 'village') && !$currentUser->inRole('admin')) {
			// Additional check for executors linked to additional objects(villages).
			if(!$model->village || $currentUser->inRole('executor') && $currentUser->additionalVillages)
			{
				$additionalVillages = $currentUser->additionalVillages()->select(['village_id'])->lists('village_id')->toArray();
				if (in_array($model->village->id, $additionalVillages)) {
					return false;
				}
				return redirect()->route($this->getRoute('index'));
			}
			if (!$model->village || (int)$model->village->id !== (int)$currentUser->village->id) {
				return redirect()->route($this->getRoute('index'));
			}
		}

		return false;
	}
}
