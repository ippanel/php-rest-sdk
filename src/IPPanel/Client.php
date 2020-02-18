<?php

namespace IPPanel;

use Exception;
use IPPanel\Models\InboxMessage;
use IPPanel\Models\Message;
use IPPanel\Models\PaginationInfo;
use IPPanel\Models\Pattern;
use IPPanel\Models\Recipient;

/**
 * IPPanel sms client
 */
class Client
{
    /**
     * Client version for setting in api call user agent header
     * @var string
     */
    const CLIENT_VERSION = "1.0.1";

    /**
     * Default timeout for api call
     * @var int
     */
    const DEFAULT_TIMEOUT = 30;

    /**
     * Api endpoint
     * @var string
     */
    const ENDPOINT = "http://rest.ippanel.com";

    /**
     * HTTP client
     * @var HTTPClient
     */
    private $_httpClient;

    /**
     * API key
     * @var string
     */
    private $_apiKey;

    /**
     * Construct ippanel sms client
     * @param string $apiKey api key
     * @param HTTPClient $httpClient http client
     */
    public function __construct($apiKey, $httpClient = null)
    {
        $this->_httpClient = $httpClient;
        $this->_apiKey = $apiKey;

        $userAgent = sprintf("IPPanel/ApiClient/%s PHP/%s",  self::CLIENT_VERSION, phpversion());

        if (!$httpClient) {
            $this->_httpClient = new HTTPClient(self::ENDPOINT, self::DEFAULT_TIMEOUT, [
                sprintf("Authorization: AccessKey %s", $this->_apiKey),
                sprintf("User-Agent: %s", $userAgent),
            ]);
        }
    }

    /**
     * Get user credit
     * @return float
     * @throws Errors\HttpException
     * @throws Errors\Error
     */
    public function getCredit()
    {
        $res = $this->_httpClient->get("/v1/credit");

        if (!isset($res->data->credit)) {
            throw new Exception("returned response not valid", 1);
        }

        return $res->data->credit;
    }

    /**
     * Send a message from originator to many recipients.
     * @param string $originator originator number
     * @param array $recipients recipients list
     * @param string $message message body
     * @return int message tracking code
     * @throws Errors\HttpException
     * @throws Errors\Error
     */
    public function send($originator, $recipients, $message)
    {
        $res = $this->_httpClient->post("/v1/messages", [
            "originator" => $originator,
            "recipients" => $recipients,
            "message" => $message,
        ]);

        if (!isset($res->data->bulk_id)) {
            throw new Exception("returned response not valid", 1);
        }

        return $res->data->bulk_id;
    }

    /**
     * Get a message brief info
     * @param int $bulkID message tracking code
     * @return Models\Message message tracking code
     * @throws Errors\HttpException
     * @throws Errors\Error
     */
    public function getMessage($bulkID)
    {
        $res = $this->_httpClient->get(sprintf("/v1/messages/%d", $bulkID));

        if (!isset($res->data->message)) {
            throw new Exception("returned response not valid", 1);
        }

        $msg = new Message();
        $msg->fromJSON($res->data->message);

        return $msg;
    }

    /**
     * Fetch message recipients status
     * @param int $bulkID message tracking code
     * @param int $page page number(start from 0)
     * @param int $limit fetch limit
     * @return Models\Recipient[] message tracking code
     * @throws Errors\HttpException
     * @throws Errors\Error
     */
    public function fetchStatuses($bulkID, $page = 0, $limit = 10)
    {
        $res = $this->_httpClient->get(sprintf("/v1/messages/%d/recipients", $bulkID), [
            'page' => $page,
            'limit' => $limit,
        ]);

        if (!isset($res->data->recipients) || !is_array($res->data->recipients)) {
            throw new Exception("returned response not valid", 1);
        }

        $statuses = [];

        foreach ($res->data->recipients as $r) {
            $status = new Recipient();
            $status->fromJSON($r);
            array_push($statuses, $status);
        }

        $paginationInfo = new PaginationInfo();
        $paginationInfo->fromJSON($res->meta);

        return array($statuses, $paginationInfo);
    }

    /**
     * Fetch inbox messages
     * @param int $page page number(start from 0)
     * @param int $limit fetch limit
     * @return Models\InboxMessage[] messages
     * @throws Errors\HttpException
     * @throws Errors\Error
     */
    public function fetchInbox($page = 0, $limit = 10)
    {
        $res = $this->_httpClient->get("/v1/messages/inbox", [
            'page' => $page,
            'limit' => $limit,
        ]);

        if (!isset($res->data->messages) || !is_array($res->data->messages)) {
            throw new Exception("returned response not valid", 1);
        }

        $messages = [];

        foreach ($res->data->messages as $r) {
            $msg = new InboxMessage();
            $msg->fromJSON($r);
            array_push($messages, $msg);
        }

        $paginationInfo = new PaginationInfo();
        $paginationInfo->fromJSON($res->meta);

        return array($messages, $paginationInfo);
    }

    /**
     * Create a pattern
     * @param string $pattern pattern schema
     * @param bool $isShared determine that pattern shared or not
     * @return Models\Pattern message tracking code
     * @throws Errors\HttpException
     * @throws Errors\Error
     */
    public function createPattern(
        $pattern,
        $isShared = false
    ) {
        $res = $this->_httpClient->post("/v1/messages/patterns", [
            'pattern' => $pattern,
            'is_shared' => $isShared,
        ]);

        if (!isset($res->data->pattern)) {
            throw new Exception("returned response not valid", 1);
        }

        $pattern = new Pattern();
        $pattern->fromJSON($res->data->pattern);

        return $pattern;
    }

    /**
     * Send message with pattern
     * @param string $patternCode pattern code
     * @param string $originator originator number
     * @param string $recipient recipient number
     * @param array $values pattern values
     * @return int message tracking code
     * @throws Errors\HttpException
     * @throws Errors\Error
     */
    public function sendPattern($patternCode, $originator, $recipient, $values)
    {
        $res = $this->_httpClient->post("/v1/messages/patterns/send", [
            "pattern_code" => $patternCode,
            "originator" => $originator,
            "recipient" => $recipient,
            "values" => $values,
        ]);

        if (!isset($res->data->bulk_id)) {
            throw new Exception("returned response not valid", 1);
        }

        return $res->data->bulk_id;
    }
}
