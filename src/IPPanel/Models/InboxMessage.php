<?php

namespace IPPanel\Models;


/**
 * Inbox message template
 */
class InboxMessage extends Base
{
    /**
     * Line number that message received on it
     * @var string
     */
    public $number;

    /**
     * Received message
     * @var string
     */
    public $message;

    /**
     * Sender number
     * @var string
     */
    public $sender;

    /**
     * Received time
     * @var string
     */
    public $time;

    /**
     * Message type
     * @var string
     */
    public $type;
}
