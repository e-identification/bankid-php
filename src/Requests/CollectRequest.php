<?php

namespace BankID\SDK\Requests;

use GuzzleHttp\Promise\PromiseInterface;
use BankID\SDK\Http\Builders\GenericRequestBuilder;
use BankID\SDK\Http\RequestClient;
use BankID\SDK\Requests\Payload\CollectPayload;
use BankID\SDK\Requests\Payload\SignPayload;
use BankID\SDK\Responses\DTO\Collect;
use BankID\SDK\Responses\Serializers\ResponseSerializer;
use function GuzzleHttp\Promise\task;

/**
 * Class CollectRequest
 *
 * @package BankID\SDK\Requests
 */
class CollectRequest extends Request
{

    protected const URI = 'collect';

    /**
     * @var SignPayload
     */
    protected $payload;

    /**
     * SignRequest constructor.
     *
     * @param RequestClient  $httpClient
     * @param CollectPayload $payload
     */
    public function __construct(RequestClient $httpClient, CollectPayload $payload)
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
            return $this->request($request->build(), new ResponseSerializer(new Collect()));
        });
    }
}
