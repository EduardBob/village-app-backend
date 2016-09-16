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
		return $this->getOrderType().'Order_'.$this->id;
	}

	/**
	 * @return array
	 */
	public static function getStatuses()
	{
		return [
			static::STATUS_PROCESSING,
			static::STATUS_RUNNING,
			static::STATUS_DONE,
			static::STATUS_REJECTED,
		];
	}

	/**
	 * Статусы, в который ордера являются ещё открытыми
	 *
	 * @return array
	 */
	public static function getOpenedStatuses()
	{
		return [
			static::STATUS_PROCESSING,
			static::STATUS_RUNNING,
		];
	}

	/**
	 * Статусы в которых оповещаются исполнители и администраторы.
	 *
	 * @return array
	 */
	public static function getManagerNotifyStatuses()
	{
		return [
		static::STATUS_PROCESSING
		];
	}

	/**
	 * Статусы в которых оповещаются клиенты.
	 *
	 * @return array
	 */
	public static function getClientNotifyStatuses()
	{
		return [
		static::STATUS_DONE,
		static::STATUS_RUNNING,
		static::STATUS_REJECTED,
		];
	}

	/**
	 * @return array
	 */
	public static function canPayInStatuses()
	{
		return [
			static::STATUS_PROCESSING,
			static::STATUS_RUNNING,
		];
	}

	/**
	 * Статусы, в которых заказы видны испольнителям
	 *
	 * @return array
	 */
	public static function getExecutorVisibleStatuses()
	{
		return [
		static::STATUS_PROCESSING,
		static::STATUS_RUNNING,
		static::STATUS_DONE,
		];
	}

}