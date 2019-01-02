<?php

namespace BankID\SDK\Tests\Unit;

use BankID\SDK\ClientAsynchronous;
use BankID\SDK\Configuration\Config;
use BankID\SDK\Requests\Payload\AuthenticationPayload;
use BankID\SDK\Requests\Payload\Meta\RequirementMeta;
use BankID\SDK\Requests\Payload\Serializers\PayloadSerializer;
use BankID\SDK\Responses\DTO\AuthenticationResponse;
use BankID\SDK\Tests\Mock\Traits\ClientMockTrait;
use BankID\SDK\Tests\TestCase;
use Doctrine\Common\Annotations\AnnotationReader;
use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use const BankID\SDK\Responses\ERROR_CODE_ALREADY_IN_PROGRESS;

class AuthenticateRequestTest extends TestCase
{

    use ClientMockTrait;

    protected const PERSONAL_NUMBER = '198112189876';
    protected const IP_ADDRESS = '127.0.0.1';

    public function testInitialRequestWithValidParameters(): void
    {
        $client = new ClientAsynchronous(new Config('INVALID_PATH_FOR_TEST_PURPOSE'), $this->getMockedClient([
            new Response(200, [], $this->getMockedAuthenticateResponseBody()),
        ]));

        $payload = new AuthenticationPayload(self::PERSONAL_NUMBER, self::IP_ADDRESS);

        $promise = $client->authenticate($payload);

        $response = $this->unwrap($promise);

        $this->assertTrue($response->isSuccess());
        $this->assertNotTrue($response->isAlreadyInProgress());
        $this->assertEquals($response->getOrderRef(), self::$ORDER_REFERENCE);
        $this->assertEquals($response->getAutoStartToken(), self::$AUTO_START_TOKEN);
        $this->assertNull($response->getErrorCode());
        $this->assertNull($response->getDetails());
    }

    public function testRequestWithAnOrderAlreadyInProgress()
    {
        $client = new ClientAsynchronous(new Config('INVALID_PATH_FOR_TEST_PURPOSE'), $this->getMockedClient([
            new Response(200, [], $this->getMockedErroneousResponseBody($errorCode = ERROR_CODE_ALREADY_IN_PROGRESS, $details = 'Order already in progress for pno')),
        ]));

        $payload = new AuthenticationPayload(self::PERSONAL_NUMBER, self::IP_ADDRESS);
        $promise = $client->authenticate($payload);

        $response = $this->unwrap($promise);

        $this->assertNotTrue($response->isSuccess());
        $this->assertTrue($response->isAlreadyInProgress());
        $this->assertNull($response->getOrderRef());
        $this->assertNull($response->getAutoStartToken());
        $this->assertEquals($response->getErrorCode(), $errorCode);
        $this->assertEquals($response->getDetails(), $details);
    }

    public function testPersonalNumberRequirements()
    {
        $client = new ClientAsynchronous(new Config('INVALID_PATH_FOR_TEST_PURPOSE'), $this->getMockedClient([
            new Response(200, [], $this->getMockedAuthenticateResponseBody()),
        ]));

        $payload = new AuthenticationPayload('', self::IP_ADDRESS);
        $promise = $client->authenticate($payload);

        $this->expectExceptionObject($this->getMockedValidationException('This value should not be blank.', 'personalNumber'));

        $this->unwrap($promise);
    }

    public function testIpAddressRequirements()
    {
        $client = new ClientAsynchronous(new Config('INVALID_PATH_FOR_TEST_PURPOSE'), $this->getMockedClient([
            new Response(200, [], $this->getMockedAuthenticateResponseBody()),
        ]));

        $payload = new AuthenticationPayload(self::PERSONAL_NUMBER, '');
        $promise = $client->authenticate($payload);

        $this->expectExceptionObject($this->getMockedValidationException('This value should not be blank.', 'endUserIp'));

        $this->unwrap($promise);
    }

    public function testEncodingOfPayload()
    {
        $requirementMeta = new RequirementMeta('asdasd', 'asdasd', 'asdasd', true, true);

        $payload = new AuthenticationPayload(self::PERSONAL_NUMBER, self::IP_ADDRESS, $requirementMeta);

        $serializer = new PayloadSerializer(new AnnotationReader());
        $encodedData = $serializer->encode($payload);

        // TODO, assertion

        $this->markTestSkipped();
    }

    // TODO, collect from response
    // TODO, cancel from response

    /**
     * Unwraps the promise.
     *
     * @param PromiseInterface $promise
     * @return AuthenticationResponse
     * @throws Exception
     */
    protected function unwrap(PromiseInterface $promise): AuthenticationResponse
    {
        return $promise->wait(true);
    }
}
