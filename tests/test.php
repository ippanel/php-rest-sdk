<?php

use IPPanel\Client;
use IPPanel\Errors\Error;
use IPPanel\Errors\ResponseCodes;

require_once __DIR__ . '/../vendor/autoload.php';

$client = new Client("Your api key");

try {
    $pattern = $client->sendPattern("your_pattern_code", "sender_number", "recipient_number", ['variable_name' => "1234"]);
    var_dump($pattern);
} catch (Error $e) {
    var_dump($e->unwrap());
    echo $e->getCode();

    if ($e->code() == ResponseCodes::ErrUnprocessableEntity) {
        echo "Unprocessable entity";
    }
} catch (Exception $e) {
    var_dump($e->getMessage());
    echo $e->getCode();
}