<?php

namespace IPPanel\Errors;

class Error extends \Exception
{
    /**
     * Error message
     * @var mixed
     */
    protected $_message;

    /**
     * Error code
     * @var string
     */
    protected $_code;


    /**
     * @inheritdoc
     */
    public function __construct($message, $code = 500)
    {
        $this->_message = $message;
        $this->_code = is_numeric($code) ? $code : 500;

        parent::__construct(json_encode($message), $code);
    }

    /**
     * Unwrap error message as is
     * @return mixed
     */
    public function unwrap()
    {
        return $this->_message;
    }

    /**
     * Get error code
     * @return string
     */
    public function code()
    {
        return $this->_code;
    }

    /**
     * Parse API errors
     * @param $response api response array
     * @return Error
     */
    public static function parseErrors($response)
    {
        if (isset($response->data) && isset($response->data->error)) {
            return new Error($response->data->error, is_numeric($response->code) ? $response->code : 500);
        }

        return false;
    }
}
