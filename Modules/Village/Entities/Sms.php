<?php namespace Modules\Village\Entities;

use Fruitware\ProstorSms\Exception\BadSmsStatusException;
use Fruitware\ProstorSms\Model\SmsInterface;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model implements SmsInterface
{
    protected $table = 'village__sms';

    protected $fillable = ['village_id', 'phone', 'text', 'sender', 'scheduled_at', 'queue_name', 'internal_id', 'status'];

    public function __construct()
    {
        $this->setStatus(static::STATUS_NONE);
    }

    public function village()
    {
        return $this->belongsTo('Modules\Village\Entities\Village', 'village_id');
    }

    /**
     * @return array
     */
    static public function getStatuses()
    {
        return [
            static::STATUS_NONE,
            static::STATUS_DELIVERED,
            static::STATUS_QUEUED,
            static::STATUS_SUBMITTED,
        ];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $phone
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string|null $sender
     *
     * @return $this
     */
    public function setSender($sender = null)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param \DateTime|null $scheduledAt
     *
     * @return $this
     */
    public function setScheduledAt(\DateTime $scheduledAt = null)
    {
        $this->scheduled_at = $scheduledAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getScheduledAt()
    {
        return $this->scheduled_at;
    }

    /**
     * @param string|null $queueName
     *
     * @return $this
     */
    public function setQueueName($queueName = null)
    {
        $this->queue_name = $queueName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getQueueName()
    {
        return $this->queue_name;
    }

    /**
     * @param int|null $internalId
     *
     * @return $this
     */
    public function setInternalId($internalId = null)
    {
        $this->internal_id = $internalId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getInternalId()
    {
        return $this->internal_id;
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @throws BadSmsStatusException
     * @return $this
     */
    public function send()
    {
        if (!$this->getId()) {
            $this->save();
        }

        try {
            smsGate()->send($this);
        }
        catch (BadSmsStatusException $ex) {
            $this->save();

	        \Log::warning($ex->getMessage(), $this->toArray());
            throw $ex;
        }

        return $this;
    }

    /**
     * @param Sms[] $smsCollection
     *
     * @return Sms[] with defined status and code
     */
    static public function sendQueue(array &$smsCollection)
    {
        \DB::beginTransaction();
        /** @var Sms $sms */
        foreach ($smsCollection as $sms) {
            if (!$sms->getId()) {
                $sms->save();
            }
        }
        \DB::commit();

        $smsCollection = smsGate()->sendQueue($smsCollection);

        \DB::beginTransaction();
        /** @var Sms $sms */
        foreach ($smsCollection as $sms) {
            $sms->save();
        }
        \DB::commit();

        return $smsCollection;
    }
}
