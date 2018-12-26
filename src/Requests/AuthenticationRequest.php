<?php

namespace BankID\SDK\Requests;

use BankID\SDK\Client;
use BankID\SDK\Http\Builders\GenericRequestBuilder;
use BankID\SDK\Http\RequestClient;
use BankID\SDK\Requests\Payload\AuthenticationPayload;
use BankID\SDK\Responses\DTO\Authentication;
use BankID\SDK\Responses\Serializers\ResponseSerializer;
use Doctrine\Common\Annotations\Reader;
use GuzzleHttp\Promise\PromiseInterface;
use function GuzzleHttp\Promise\task;

/**
 * Class AuthenticationRequest
 *
 * @package            BankID\SDK\Requests
 * @internal
 * @phan-file-suppress PhanAccessMethodInternal
 */
class AuthenticationRequest extends Request
{

    protected const URI = 'auth';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var AuthenticationPayload
     */
    protected $payload;

    /**
     * @var Reader
     */
    protected $annotationReader;

    /**
     * AuthenticationRequest constructor.
     *
     * @param Client                $client
     * @param RequestClient         $httpClient
     * @param Reader                $annotationReader
     * @param AuthenticationPayload $payload
     */
    public function __construct(
        Client $client,
        RequestClient $httpClient,
        Reader $annotationReader,
        AuthenticationPayload $payload
    ) {
        parent::__construct($httpClient, $annotationReader);

        $this->client = $client;
        $this->payload = $payload;
        $this->httpClient = $httpClient;
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
            return $this->request($request->build(), new ResponseSerializer(new Authentication($this->client)));
        });
    }
}
