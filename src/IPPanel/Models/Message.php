<?php

namespace IPPanel\Models;

/**
 * Message base template
 */
class Message extends Base
{
    /**
     * Message tracking code
     * @var string
     */
    public $bulkId = Null;

    /**
     * Originator number
     * @var string
     */
    public $number = Null;

    /**
     * Message body
     * @var string
     */
    public $message = Null;

    /**
     * Message status
     * @var string
     */
    public $status = Null;

    /**
     * Message type
     * @var string
     */
    public $type = Null;

    /**
     * Message confirmation status
     * @var string
     */
    public $confirmState = Null;

    /**
     * Created at
     * @var string
     */
    public $createdAt = Null;

    /**
     * Message send time
     * @var string
     */
    public $sentAt = Null;

    /**
     * Message recipients count
     * @var string
     */
    public $recipientsCount = Null;

    /**
     * Recipients that passed validation 
     * @var string
     */
    public $validRecipientsCount = Null;

    /**
     * Message number of pages
     * @var string
     */
    public $page = Null;

    /**
     * Message cost
     * @var string
     */
    public $cost = Null;

    /**
     * Message payback cost
     * @var string
     */
    public $paybackCost = Null;

    /**
     * Brief info about message
     * @var string
     */
    public $description = Null;
}
