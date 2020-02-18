<?php

namespace IPPanel\Models;

/**
 * Pattern base model
 */
class Pattern extends Base
{
    /**
     * Pattern unique code
     * @var string
     */
    public $code;

    /**
     * Pattern status
     * @var string
     */
    public $status;

    /**
     * Pattern content
     * @var string
     */
    public $message;

    /**
     * Pattern shared or not
     * @var string
     */
    public $isShared;
}
