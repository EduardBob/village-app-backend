<?php
namespace Modules\Village\Entities;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractOrder extends Model implements OrderInterface
{
	/**
	 * @return string
	 */
	abstract public function getOrderType();

	/**
	 * @return string
	 */
	public function getOrderNameForCardPayment()
	{
		return $this->getOrderType().'_'.$this->id;
	}

	/**
	 * @return array
	 */
	public function getStatuses()
	{
		return [
			static::STATUS_PROCESSING,
			static::STATUS_RUNNING,
			static::STATUS_DONE,
			static::STATUS_REJECTED,
		];
	}

	/**
	 * @return array
	 */
	public function canPayInStatuses()
	{
		return [
			static::STATUS_PROCESSING,
			static::STATUS_RUNNING,
		];
	}
}