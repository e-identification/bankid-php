<?php

namespace BankID\SDK\Requests;

use GuzzleHttp\Promise\PromiseInterface;
use BankID\SDK\Http\Builders\GenericRequestBuilder;
use BankID\SDK\Http\RequestClient;
use BankID\SDK\Requests\Payload\SignPayload;
use BankID\SDK\Responses\DTO\Sign;
use BankID\SDK\Responses\Serializers\ResponseSerializer;
use function GuzzleHttp\Promise\task;

/**
 * Class SignRequest
 *
 * @package BankID\SDK\Requests
 */
class SignRequest extends Request
{

    protected const URI = 'sign';

    /**
     * @var SignPayload
     */
    protected $payload;

    /**
     * SignRequest constructor.
     *
     * @param RequestClient $httpClient
     * @param SignPayload   $payload
     */
    public function __construct(RequestClient $httpClient, SignPayload $payload)
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
            return $this->request($request->build(), new ResponseSerializer(new Sign()));
        });
    }
}
