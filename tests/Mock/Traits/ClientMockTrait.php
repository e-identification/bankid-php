<?php

namespace BankID\SDK\Tests\Mock\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;

/**
 * Trait ClientMockTrait
 *
 * @package BankID\SDK\Tests\Mock\Traits
 */
trait ClientMockTrait
{

    protected static $ORDER_REFERENCE = '131daac9-16c6-4618-beb0-365768f37288';
    protected static $AUTO_START_TOKEN = '7c40b5c9-fa74-49cf-b98c-bfe651f9a7c6';

    /**
     * Returns a mocked Guzzle client.
     *
     * @param ResponseInterface[] $responses
     * @return Client
     */
    public function getMockedClient(array $responses): Client
    {
        $handler = HandlerStack::create(new MockHandler($responses));

        return new Client(['handler' => $handler]);
    }

    /**
     * Returns mocked sign response body.
     *
     * @param string|null $orderReference
     * @param string|null $autoStartToken
     * @return string
     */
    public function getMockedSignResponseBody(string $orderReference = null, string $autoStartToken = null): string
    {
        return sprintf('{
            "orderRef":"%s",
            "autoStartToken":"%s"
        }', $orderReference ?? self::$ORDER_REFERENCE, $autoStartToken ?? self::$AUTO_START_TOKEN);
    }

    /**
     * Returns mocked erroneous sign response body.
     *
     * @param string $errorCode
     * @param string $details
     * @return string
     */
    public function getMockedErroneousResponseBody(string $errorCode, string $details): string
    {
        return sprintf('{
            "orderRef":null,
            "autoStartToken":null,
            "errorCode":"%s",
            "details":"%s"
        }', $errorCode, $details);
    }

    /**
     * Returns mocked authenticate response body.
     *
     * @param string|null $orderReference
     * @param string|null $autoStartToken
     * @return string
     */
    public function getMockedAuthenticateResponseBody(string $orderReference = null, string $autoStartToken = null): string
    {
        return sprintf('{
            "orderRef":"%s",
            "autoStartToken":"%s"
        }', $orderReference ?? self::$ORDER_REFERENCE, $autoStartToken ?? self::$AUTO_START_TOKEN);
    }

    /**
     * Returns mocked pending collect response body.
     *
     * @param string $orderRefernece
     * @param string $hintCode
     * @return string
     */
    public function getMockedPendingCollectResponseBody(string $orderRefernece, string $hintCode): string
    {
        return sprintf('{
            "orderRef":"%s",
            "status":"pending",
            "hintCode":"%s"
        }', $orderRefernece, $hintCode);
    }

    /**
     * Returns mocked complete collect response body.
     */
    public function getMockedCompleteCollectResponseBody(): string
    {
        return sprintf('{
            "orderRef": "131daac9-16c6-4618-beb0-365768f37288",
            "status": "complete",
            "completionData": {
                "user": {
                    "personalNumber": "190000000000",
                    "name": "Karl Karlsson",
                    "givenName": "Karl",
                    "surname": "Karlsson"
                },
                "device": {
                    "ipAddress": "192.168.0.1"
                },
                "cert": {
                    "notBefore": "1502983274000",
                    "notAfter": "1563549674000"
                },
                "signature": "",
                "ocspResponse": ""
            }
        }');
    }

    /**
     * Returns mocked cancel collect response body.
     *
     * @return string
     */
    public function getMockedCancelCollectResponseBody(): string
    {
        return '{}';
    }
}
