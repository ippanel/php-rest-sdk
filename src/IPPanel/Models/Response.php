<?php

namespace IPPanel\Models;

/**
 * API response pagination info
 */
class PaginationInfo extends Base
{
    /**
     * total count
     * @var int
     */
    public $total = 0;

    /**
     * pagination limit
     * @var int
     */
    public $limit = 0;

    /**
     * current page
     * @var int
     */
    public $page = 0;

    /**
     * total pages
     * @var int
     */
    public $pages = 0;

    /**
     * preview resource
     * @var Null|string
     */
    public $prev = Null;

    /**
     * next resource
     * @var Null|string
     */
    public $next = Null;
}

/**
 * API response template
 */
class Response extends Base
{
    /**
     * http status code
     * @var int
     */
    public $status = 200;

    /**
     * ippanel response code
     * @var string
     */
    public $code = "";

    /**
     * response data
     * @var mixed
     */
    public $data = Null;

    /**
     * meta data
     * @var Null|\PaginationInfo
     */
    public $meta = Null;
}
