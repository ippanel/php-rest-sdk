<?php

namespace IPPanel;

use IPPanel\Errors\Error;
use IPPanel\Models\Response;

/**
 * HTTPClient is a abstract client implementation for http
 */
class HTTPClient
{
    /**
     * Request base url
     * @var string
     */
    private $_baseURL = "";

    /**
     * Request connection & response timeout in seconds
     * @var int
     */
    private $_timeout = 30;

    /**
     * Request headers
     * @var array
     */
    private $_headers = [];

    /**
     * Supported http response codes
     */
    private $_supportedStatusCodes = [200, 201, 204, 405, 400, 404, 401, 422];

    /**
     * Http client constructor
     * @param string $baseURL base url for client
     * @param int $timeout request timeout
     * @param array $headers request headers
     */
    public function __construct($baseURL, $timeout = 30, $headers = [])
    {
        $this->_baseURL = $baseURL;

        if ($timeout > 0) {
            $this->_timeout = $timeout;
        }

        $this->_headers = $headers;
    }

    /**
     * Make a based url with given uri and query parameters
     * @param string $uri uri
     * @param array $params query params
     * @return string
     */
    public function getBasedURL($uri, $params = null)
    {
        if (!$uri && !$params) {
            throw new \InvalidArgumentException("function needs at least one argument");
        }

        $url = rtrim($this->_baseURL, '/');

        $url .= '/' . ltrim($uri, '/');

        if ($params) {
            $query = http_build_query($params);
            $url .= "?" . $query;
        }

        return $url;
    }

    /**
     * Make custom http request
     * @param string $method http method
     * @param string $url request url
     * @param mixed $data request data
     * @param array $params query parameters
     * @param array $headers http headers 
     * @return Models\Response parsed response
     * @throws Errors\HttpException
     * @throws Errors\Error
     */
    public function request(
        $method = "GET",
        $url,
        $data = null,
        $params = null,
        $headers = null
    ) {
        $curl = curl_init();

        if (!$headers || count($headers) < 1) {
            $headers = ['Accept: application/json', 'Content-Type: application/json'];
        }

        $headers = array_merge($headers, $this->_headers);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_URL, $this->getBasedURL($url, $params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // no need in php 5.1.3+.
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->_timeout);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->_timeout);

        switch ($method) {
            case 'GET':
                curl_setopt($curl, CURLOPT_HTTPGET, true);
                break;
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, @json_encode($data));
                break;
            default:
                curl_setopt($curl, CURLOPT_HTTPGET, true);
        }

        $response = curl_exec($curl);

        if ($response === false) {
            throw new Errors\HttpException(curl_error($curl), curl_errno($curl));
        }

        // get http status
        $status = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        // http status code is parsable or not 
        if (!in_array($status, $this->_supportedStatusCodes)) {
            throw new Errors\HttpException("unexpected http error occurred", $status);
        }

        $arrayResponse = json_decode($response);

        // marshal received response to base Response object
        $parsedResponse = new Response();
        $parsedResponse->fromJSON($arrayResponse);

        $errors = Error::parseErrors($parsedResponse);
        if ($errors) {
            throw $errors;
        }

        return $parsedResponse;
    }

    /**
     * Make http GET request
     * @param string $url request url
     * @param array|Null $params query parameters 
     * @param array|Null $headers http headers
     * @return Models\Response parsed response
     * @throws Errors\HttpException
     * @throws Errors\Error
     */
    public function get($url, $params = Null, $headers = Null)
    {
        return $this->request("GET", $url, Null, $params, $headers);
    }

    /**
     * Make http POST request
     * @param string $url request url
     * @param mixed $data request body
     * @param array|Null $headers http headers
     * @return Models\Response parsed response
     * @throws Errors\HttpException
     * @throws Errors\Error
     */
    public function post($url, $data, $headers = null)
    {
        return $this->request("POST", $url, $data, Null, $headers);
    }
}
