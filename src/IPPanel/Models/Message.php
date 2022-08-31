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
    public $messageId = Null;

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
    public $state = Null;

    /**
     * Message type
     * @var string
     */
    public $type = Null;

    /**
     * Message confirmation status
     * @var string
     */
    public $valid = Null;

    /**
     * Created at
     * @var string
     */
    public $time = Null;

    /**
     * Message send time
     * @var string
     */
    public $timeSend = Null;

    /**
     * Message recipients count
     * @var string
     */
    public $recipientCount = Null;

    /**
     * Recipients that passed validation 
     * @var string
     */
    public $exitCount = Null;

    /**
     * Message number of parts
     * @var string
     */
    public $part = Null;

    /**
     * Message cost
     * @var string
     */
    public $cost = Null;

    /**
     * Message payback cost
     * @var string
     */
    public $returnCost = Null;

    /**
     * Brief info about message
     * @var string
     */
    public $summary = Null;
}
