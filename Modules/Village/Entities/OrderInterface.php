<?php
namespace Modules\Village\Entities;

interface OrderInterface
{
	const STATUS_PROCESSING = 'processing';
	const STATUS_RUNNING = 'running';
	const STATUS_DONE = 'done';
	const STATUS_REJECTED = 'rejected';

	const PAYMENT_TYPE_CASH = 'cash';
	const PAYMENT_TYPE_CARD = 'card';

	const PAYMENT_STATUS_NOT_PAID = 'not_paid';
	const PAYMENT_STATUS_PAID = 'paid';

	/**
	 * @return string
	 */
	public function getOrderType();

	/**
	 * @return array
	 */
	public static function getStatuses();

	/**
	 * Статусы, в который ордера являются ещё открытыми
	 *
	 * @return array
	 */
	public static function getOpenedStatuses();

	/**
	 * @return array
	 */
	public static function canPayInStatuses();

	/**
	 * @return string
	 */
	public function getOrderNameForCardPayment();
}