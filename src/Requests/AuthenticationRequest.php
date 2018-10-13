<?php

namespace BankID\SDK\Requests;

use GuzzleHttp\Promise\PromiseInterface;
use BankID\SDK\Http\Builders\GenericRequestBuilder;
use BankID\SDK\Http\RequestClient;
use BankID\SDK\Requests\Payload\AuthenticationPayload;
use BankID\SDK\Responses\DTO\Authentication;
use BankID\SDK\Responses\Serializers\ResponseSerializer;
use function GuzzleHttp\Promise\task;

/**
 * Class AuthenticationRequest
 *
 * @package BankID\SDK\Requests
 */
class AuthenticationRequest extends Request
{

    protected const URI = 'auth';

    /**
     * @var AuthenticationPayload
     */
    protected $payload;

    /**
     * AuthRequest constructor.
     *
     * @param RequestClient         $httpClient
     * @param AuthenticationPayload $payload
     */
    public function __construct(RequestClient $httpClient, AuthenticationPayload $payload)
    {
        parent::__construct($httpClient);

        $this->payload = $payload;
    }

    /**
     * Executes the request.
     *
     * @return PromiseInterface
     */
    public function fire(): PromiseInterface
    {
        return task(function (): PromiseInterface {
            // Build the request instance
            $request = (new GenericRequestBuilder(self::URI, $this->httpClient->getConfig()))
                ->setPayload($this->payload);

            // Return a promise chain
            return $this->request($request->build(), new ResponseSerializer(new Authentication()));
        });
    }
}
