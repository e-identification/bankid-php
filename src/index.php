<?php

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use BankID\SDK\Client;
use BankID\SDK\Configuration\Config;
use BankID\SDK\Http\Builders\GenericRequestBuilder;
use BankID\SDK\Http\RequestClient;
use BankID\SDK\Requests\Payload\CancelPayload;
use BankID\SDK\Requests\Payload\CollectPayload;
use BankID\SDK\Requests\Payload\Serializers\PayloadSerializer;
use BankID\SDK\Requests\Payload\AuthenticationPayload;
use BankID\SDK\Requests\Payload\SignPayload;

require_once "vendor/autoload.php";

AnnotationRegistry::registerLoader('class_exists');

$payload = new SignPayload("198806010313", "123.123.123.123", "123123");

$options = new Config(Config::ENVIRONMENT_TEST, __DIR__ . '/../rsc/certificates/cert.pem');

$client = new \GuzzleHttp\Client(array('verify' => false));
$client = new Client(new RequestClient($options, $client));

//$promise = $client->sign($payload);
$promise = $client->cancel(new CancelPayload("b39c505d-2a55-4835-aab8-3631c8eca2c7"));

$result = $promise->wait(true);

var_dump($result);

die();


// Utöka funktionaliteten i response-objekt, möjligt att direkt göra anrop.
// Möjlighet att ange en annotation reader
// Ta fram ett skript för att generera certifikat
// Lägg till funktionalitet för travisci
// Skriv README.md
// Unittester
// Spara reflection data, eller använd getter för att hämta data




// Examples
// Validation unittests
// Pass annotation reader
// Proxy, or decorator to skip the promise handling
// Hantera alla todos
// Example on how to generate .pem file


// Pass the environment


// $request
$data = "metadata";

// middleware
$a = function ($data, $next) {
    return $next($data);
};

// middleware
$b = function ($data, $next) {
    $next($data);

    return 'some metadata';
};

// controller
$lastInPipe = function ($data) {
    return 'asdasad';
};

$pipe = [$a, clone $a, clone $a, $b, $lastInPipe];

$next = function ($data) use (&$pipe, &$next) {
    $item = array_shift($pipe);

    if ($item === null) {
        return;
    }

    return $item($data, $next);
};

$result = $a($data, $next);

var_dump($result);

die();

var_dump($b);


die();


// Cannot autowire service &quot;App\Services\BankIDService&quot

$options = new Config(Config::ENVIRONMENT_TEST, __DIR__ . '/../rsc/certificates/cert.pem');

$client = new \GuzzleHttp\Client(array('verify' => false));
//$client = new \GuzzleHttp\Client();
$client = new Client(new RequestClient($options, $client));

$authenticationPayload = new AuthenticationPayload('198806010313', '194.168.2.25');

$promise = $client->authenticate($authenticationPayload);

/**
 * @var $result \BankID\SDK\Responses\DTO\Authentication
 */
$result = $promise->wait(true);

var_dump($result);

$collectPayload = new CollectPayload($result->getOrderRef());

$promise = $client->collect($collectPayload);
$result = $promise->wait(true);

var_dump($result);


die();


$collectPayload = new CollectPayload();
$collectPayload->setOrderRef("asdasdasd");
$promise = $client->collect($collectPayload);
$result = $promise->wait(true);

var_dump($result);


die();


// EXAMPLE AUTHENTICATION PAYLOAD

$authenticationPayload = new AuthenticationPayload();
$authenticationPayload->setEndUserIp('194.168.2.25');
$authenticationPayload->setPersonalNumber('198806010313');

$promise = $client->authenticate($authenticationPayload);
$result = $promise->wait(true);

var_dump($result);

die();

// EXAMPLE SIGN PAYLOAD

$signPayload = new SignPayload();
$signPayload->setEndUserIp('194.168.2.25');
$signPayload->setPersonalNumber('198806010313');
$signPayload->setUserVisibleData("asdasdasd");

$promise = $client->sign($signPayload);

$result = $promise->wait(true);

var_dump($result);


die();

$payload = new AuthenticationPayload();
$payload->setEndUserIp('asdasdasd');

$serializer = new PayloadSerializer(new AnnotationReader());
$result = $serializer->CancelRequest . php($payload);

var_dump($result);

$request = (new GenericRequestBuilder('asdasd'))
    ->setPayload($payload);

var_dump($request->build());
