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
    public $to;

    /**
     * Received message
     * @var string
     */
    public $message;

    /**
     * Sender number
     * @var string
     */
    public $from;

    /**
     * Received time
     * @var string
     */
    public $createdAt;

    /**
     * Message type
     * @var string
     */
    public $type;
}
