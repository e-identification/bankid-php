<?php

namespace BankID\SDK\Requests;

use Doctrine\Common\Annotations\Reader;
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
     * @param RequestClient $httpClient
     * @param Reader        $annotationReader
     * @param CancelPayload $payload
     */
    public function __construct(RequestClient $httpClient, Reader $annotationReader, CancelPayload $payload)
    {
        parent::__construct($httpClient, $annotationReader);

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
            $request = (new GenericRequestBuilder(self::URI, $this->httpClient->getConfig(), $this->annotationReader))
                ->setPayload($this->payload);

            // Return a promise chain
            return $this->request($request->build(), new ResponseSerializer(new Cancel()));
        });
    }
}
