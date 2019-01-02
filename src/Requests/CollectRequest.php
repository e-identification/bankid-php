<?php

declare(strict_types=1);

namespace BankID\SDK\Requests;

use BankID\SDK\ClientAsynchronous;
use BankID\SDK\Http\Builders\GenericRequestBuilder;
use BankID\SDK\Requests\Payload\CollectPayload;
use BankID\SDK\Requests\Payload\SignPayload;
use BankID\SDK\Responses\DTO\CollectResponse;
use BankID\SDK\Responses\Serializers\ResponseSerializer;
use GuzzleHttp\Promise\PromiseInterface;
use function GuzzleHttp\Promise\task;

/**
 * Class CollectRequest
 *
 * @package            BankID\SDK\Requests
 * @internal
 * @phan-file-suppress PhanAccessMethodInternal
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
     * @param ClientAsynchronous         $client
     * @param CollectPayload $payload
     */
    public function __construct(ClientAsynchronous $client, CollectPayload $payload)
    {
        parent::__construct($client->getClient(), $client->getAnnotationReader(), $client->getConfig());

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
            $request = (new GenericRequestBuilder(self::URI, $this->config, $this->annotationReader))
                ->setPayload($this->payload);

            // Return a promise chain
            return $this->request($request->build(), new ResponseSerializer(new CollectResponse()));
        });
    }
}
