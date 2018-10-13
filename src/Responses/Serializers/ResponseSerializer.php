<?php

namespace BankID\SDK\Responses\Serializers;

use Exception;
use BankID\SDK\Exceptions\InvalidRequestException;
use BankID\SDK\Responses\DTO\Envelope;
use BankID\SDK\Responses\Interfaces\SerializerInterface;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

/**
 * Class ResponseSerializer
 *
 * @package BankID\SDK\Responses\Serializers
 */
class ResponseSerializer implements SerializerInterface
{

    /**
     * @var int[] The known API endpoints status codes
     */
    protected const KNOWN_STATUS_CODES = [200, 400, 401, 404, 408, 415, 500, 503];

    /**
     * @var string Empty server response
     */
    protected const EMPTY_RESPONSE = '{}';

    /**
     * @var Envelope
     */
    protected $envelope;

    /**
     * ResponseSerializer constructor.
     *
     * @param Envelope $envelope
     */
    public function __construct(Envelope $envelope)
    {
        $this->envelope = $envelope;
    }

    /**
     * Decodes the response message.
     *
     * @param HttpResponseInterface $response
     * @return Envelope
     * @throws Exception
     */
    public function decode(HttpResponseInterface $response): Envelope
    {
        if (!$this->isValidHttpResponse($response)) {
            $this->handleInvalidHttpResponse($response);
        }

        if (!$this->isSerializablePayload($body = (string)$response->getBody())) {
            return $this->envelope;
        }

        $this->envelope->mapFromJson((string)$response->getBody());

        return $this->envelope;
    }

    /**
     * Returns true if the data is serializable, false otherwise.
     *
     * @param string $response
     * @return bool
     */
    protected function isSerializablePayload(string $response): bool
    {
        return $response !== null && $response !== self::EMPTY_RESPONSE;
    }

    /**
     * Check whether we retrieved a successful HTTP response, false otherwise.
     *
     * @param HttpResponseInterface $response
     * @return bool
     */
    protected function isValidHttpResponse(HttpResponseInterface $response): bool
    {
        return in_array($response->getStatusCode(), self::KNOWN_STATUS_CODES);
    }

    /**
     * Handle invalid HTTP response.
     *
     * @param HttpResponseInterface $response
     * @throws InvalidRequestException
     */
    protected function handleInvalidHttpResponse(HttpResponseInterface $response): void
    {
        throw new InvalidRequestException((string)$response->getBody());
    }
}
