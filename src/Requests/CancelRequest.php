<?php

namespace BankID\SDK\Requests;

use GuzzleHttp\Promise\PromiseInterface;
use BankID\SDK\Http\Builders\GenericRequestBuilder;
use BankID\SDK\Http\RequestClient;
use BankID\SDK\Requests\Payload\CancelPayload;
use BankID\SDK\Responses\DTO\Cancel;
use BankID\SDK\Responses\Serializers\ResponseSerializer;
use function GuzzleHttp\Promise\task;

/**
 * Class CancelRequest
 *
 * @package BankID\SDK\Requests
 */
class CancelRequest extends Request
{

    protected const URI = 'cancel';

    /**
     * @var CancelPayload
     */
    protected $payload;

    /**
     * SignRequest constructor.
     *
     * @param RequestClient  $httpClient
     * @param CancelPayload $payload
     */
    public function __construct(RequestClient $httpClient, CancelPayload $payload)
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
            return $this->request($request->build(), new ResponseSerializer(new Cancel()));
        });
    }
}
