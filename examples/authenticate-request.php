<?php

require_once __DIR__ . "/../vendor/autoload.php";

use BankID\SDK\Client;
use BankID\SDK\Configuration\Config;
use BankID\SDK\Requests\Payload\AuthenticationPayload;
use BankID\SDK\Responses\DTO\AuthenticationResponse;
use Doctrine\Common\Annotations\AnnotationRegistry;

AnnotationRegistry::registerLoader('class_exists');

$configuration = new Config(__DIR__ . '/../rsc/certificates/cert.pem');
$client = new Client($configuration);

$result = $client->authenticate(
    new AuthenticationPayload('<PERSONAL NUMBER>', '<IP ADDRESS>'));

var_dump($result->isSuccess());
