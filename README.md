# IPPanel SMS php api SDK

[![Build Status](https://travis-ci.org/ippanel/php-rest-sdk.svg?branch=master)](https://travis-ci.org/ippanel/php-rest-sdk)

## Installation

use with composer:

```bash
composer require ippanel/php-rest-sdk
```

if you don't want to use composer, you can download it directly :

```bash
wget https://github.com/ippanel/php-rest-sdk/archive/master.zip
```

## Examples

For using sdk, you have to create a client instance that gives you available methods on API

```php
require 'autoload.php';

// you api key that generated from panel
$apiKey = "api-key";

$client = new \IPPanel\Client($apiKey);

...
```

### Credit check

```php
# return float64 type credit amount
$credit = $client->getCredit();

```

### Send one to many

For sending sms, obviously you need `originator` number, `recipients` and `message`.

```php
$messageId = $client->send(
    "+9810001",          // originator
    ["98912xxxxxxx"],    // recipients
    "ippanel is awesome",// message
    "description"        // is logged
);

```

If send is successful, a unique tracking code returned and you can track your message status with that.

### Get message summery

```php
$messageId = "message-tracking-code";

$message = $client->get_message($messageId);

echo $message->state;   // get message status
echo $message->cost;     // get message cost
echo $message->returnCost;  // get message payback
```

### Get message delivery statuses

```php
$messageId = "message-tracking-code"

list($statuses, $paginationInfo) = $client->fetchStatuses($messageId, 0, 10)

// you can loop in messages statuses list
foreach($statuses as status) {
    echo sprintf("Recipient: %s, Status: %s", $status->recipient, $status->status);
}

echo sprintf("Total: ", $paginationInfo->total);
```

### Inbox fetch

fetch inbox messages

```php
list($messages, $paginationInfo) = $client->fetchInbox(0, 10);

foreach($messages as $message) {
    echo sprintf("Received message %s from number %s in line %s", $message->message, $message->from, $message->to);
}
```

### Pattern create

For sending messages with predefined pattern(e.g. verification codes, ...), you hav to create a pattern. a pattern at
least have a parameter.

```php
$patternVariables = [
    "name" => "string",
    "code" => "integer",
];

$code = $client->createPattern("%name% is awesome, your code is %code%", "description", 
    $patternVariables, '%', False);

echo $code;
```

### Send with pattern

```php
$patternValues = [
    "name" => "IPPANEL",
];

$messageId = $client->sendPattern(
    "t2cfmnyo0c",    // pattern code
    "+9810001",      // originator
    "98912xxxxxxx",  // recipient
    $patternValues,  // pattern values
);
```

### Error checking

```php
use IPPanel\Errors\Error;
use IPPanel\Errors\HttpException;

try{
    $messageId = $client->send("9810001", ["98912xxxxx"], "ippanel is awesome");
} catch (Error $e) { // ippanel error
    var_dump($e->unwrap()); // get real content of error
    echo $e->getCode();

    // error codes checking
    if ($e->code() == ResponseCodes::ErrUnprocessableEntity) {
        echo "Unprocessable entity";
    }
} catch (HttpException $e) { // http error
    var_dump($e->getMessage()); // get stringified error
    echo $e->getCode();
}
```
