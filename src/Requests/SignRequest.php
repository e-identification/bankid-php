<?php

declare(strict_types=1);

namespace BankID\SDK\Requests;

use BankID\SDK\ClientAsynchronous;
use BankID\SDK\Http\Builders\GenericRequestBuilder;
use BankID\SDK\Requests\Payload\SignPayload;
use BankID\SDK\Responses\DTO\Asynchronous\SignResponse;
use BankID\SDK\Responses\Serializers\ResponseSerializer;
use GuzzleHttp\Promise\PromiseInterface;
use function GuzzleHttp\Promise\task;

/**
 * Class SignRequest
 *
 * @package            BankID\SDK\Requests
 * @internal
 * @phan-file-suppress PhanAccessMethodInternal
 */
class SignRequest extends Request
{

    protected const URI = 'sign';

    /**
     * @var ClientAsynchronous
     */
    protected $client;

    /**
     * @var SignPayload
     */
    protected $payload;

    /**
     * @var string
     */
    protected $envelope;

    /**
     * SignRequest constructor.
     *
     * @param ClientAsynchronous $client
     * @param SignPayload $payload
     * @param string|null $envelope
     */
    public function __construct(ClientAsynchronous $client, SignPayload $payload, ?string $envelope = null)
    {
        parent::__construct($client->getClient(), $client->getAnnotationReader(), $client->getConfig());

        $this->client = $client;
        $this->payload = $payload;
        $this->envelope = $envelope ?? SignResponse::class;
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
            return $this->request($request->build(), new ResponseSerializer(new $this->envelope($this->client)));
        });
    }
}
