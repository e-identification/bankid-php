<?php

namespace BankID\SDK\Tests\Unit;

use BankID\SDK\ClientAsynchronous;
use BankID\SDK\Configuration\Config;
use BankID\SDK\Requests\Payload\CancelPayload;
use BankID\SDK\Requests\Payload\CollectPayload;
use BankID\SDK\Requests\Payload\Serializers\PayloadSerializer;
use BankID\SDK\Responses\DTO\CancelResponse;
use BankID\SDK\Responses\DTO\CollectResponse;
use BankID\SDK\Responses\DTO\Envelope;
use BankID\SDK\Tests\Mock\Traits\ClientMockTrait;
use BankID\SDK\Tests\TestCase;
use Doctrine\Common\Annotations\AnnotationReader;
use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;

class CollectRequestTest extends TestCase
{

    use ClientMockTrait;

    public function testPendingCollect(): void
    {
        $client = new ClientAsynchronous(new Config('INVALID_PATH_FOR_TEST_PURPOSE'), $this->getMockedClient([
            new Response(200, [], $this->getMockedPendingCollectResponseBody(self::$ORDER_REFERENCE, 'userSign')),
        ]));

        $payload = new CollectPayload(self::$ORDER_REFERENCE);

        $promise = $client->collect($payload);

        $response = $this->unwrap($promise);

        $this->assertTrue($response->isSuccess());
        $this->assertNotTrue($response->isAlreadyInProgress());
        $this->assertEquals($response->getOrderRef(), self::$ORDER_REFERENCE);
        $this->assertNull($response->getCompletionData());
        $this->assertNull($response->getErrorCode());
        $this->assertNull($response->getDetails());
    }

    public function testCompletePendingCollect()
    {
        $client = new ClientAsynchronous(new Config('INVALID_PATH_FOR_TEST_PURPOSE'), $this->getMockedClient([
            new Response(200, [], $this->getMockedCompleteCollectResponseBody(self::$ORDER_REFERENCE, 'userSign')),
        ]));

        $payload = new CollectPayload(self::$ORDER_REFERENCE);

        $promise = $client->collect($payload);

        $response = $this->unwrap($promise);

        $this->assertTrue($response->isSuccess());
        $this->assertNotTrue($response->isAlreadyInProgress());
        $this->assertEquals($response->getOrderRef(), self::$ORDER_REFERENCE);
    }

    public function testEncodingOfPayload()
    {
        $payload = new CollectPayload(self::$ORDER_REFERENCE);

        $serializer = new PayloadSerializer(new AnnotationReader());
        $encodedData = $serializer->encode($payload);

        // TODO, assertion

        $this->markTestSkipped();
    }

    /**
     * Unwraps the promise.
     *
     * @param PromiseInterface $promise
     * @return CollectResponse
     * @throws Exception
     */
    protected function unwrap(PromiseInterface $promise): CollectResponse
    {
        return $promise->wait(true);
    }
}
