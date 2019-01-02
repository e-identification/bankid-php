<?php

namespace BankID\SDK\Tests\Unit;

use BankID\SDK\ClientAsynchronous;
use BankID\SDK\Configuration\Config;
use BankID\SDK\Requests\Payload\CancelPayload;
use BankID\SDK\Requests\Payload\Meta\RequirementMeta;
use BankID\SDK\Requests\Payload\Serializers\PayloadSerializer;
use BankID\SDK\Requests\Payload\SignPayload;
use BankID\SDK\Responses\DTO\CancelResponse;
use BankID\SDK\Responses\DTO\SignResponse;
use BankID\SDK\Tests\Mock\Traits\ClientMockTrait;
use BankID\SDK\Tests\TestCase;
use Doctrine\Common\Annotations\AnnotationReader;
use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use const BankID\SDK\Responses\ERROR_CODE_ALREADY_IN_PROGRESS;

class CancelRequestTest extends TestCase
{

    use ClientMockTrait;

    protected const PERSONAL_NUMBER = '198112189876';
    protected const IP_ADDRESS = '127.0.0.1';

    public function testCancelPendingCollect()
    {
        $client = new ClientAsynchronous(new Config('INVALID_PATH_FOR_TEST_PURPOSE'), $this->getMockedClient([
            new Response(200, [], $this->getMockedCancelCollectResponseBody()),
        ]));

        $payload = new CancelPayload(self::$ORDER_REFERENCE);

        $promise = $client->cancel($payload);

        /**
         * @var CancelResponse $response
         */
        $response = $this->unwrap($promise);

        $this->assertTrue($response->isSuccess());
    }

    public function testEncodingOfPayload()
    {
        $requirementMeta = new RequirementMeta('asdasd', 'asdasd', 'asdasd', true, true);

        $payload = new CancelPayload(self::PERSONAL_NUMBER, self::IP_ADDRESS, 'A visible message', $requirementMeta, 'None visible data');

        $serializer = new PayloadSerializer(new AnnotationReader());
        $encodedData = $serializer->encode($payload);

        // TODO, assertion

        $this->markTestSkipped();
    }

    /**
     * Unwraps the promise.
     *
     * @param PromiseInterface $promise
     * @return CancelResponse
     * @throws Exception
     */
    protected function unwrap(PromiseInterface $promise): CancelResponse
    {
        return $promise->wait(true);
    }
}
