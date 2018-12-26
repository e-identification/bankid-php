<?php

namespace BankID\SDK\Requests;

use BankID\SDK\Http\Builders\GenericRequestBuilder;
use BankID\SDK\Http\RequestClient;
use BankID\SDK\Requests\Payload\CollectPayload;
use BankID\SDK\Requests\Payload\SignPayload;
use BankID\SDK\Responses\DTO\Collect;
use BankID\SDK\Responses\Serializers\ResponseSerializer;
use Doctrine\Common\Annotations\Reader;
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
     * @param RequestClient  $httpClient
     * @param Reader         $annotationReader
     * @param CollectPayload $payload
     */
    public function __construct(RequestClient $httpClient, Reader $annotationReader, CollectPayload $payload)
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
            return $this->request($request->build(), new ResponseSerializer(new Collect()));
        });
    }
}
