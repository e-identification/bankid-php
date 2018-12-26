<?php

namespace BankID\SDK\Requests\Traits;

use BankID\SDK\Http\RequestClient;
use BankID\SDK\Responses\DTO\Envelope;
use BankID\SDK\Responses\Interfaces\SerializerInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use Throwable;
use function GuzzleHttp\Promise\rejection_for;
use function GuzzleHttp\Promise\task;

/**
 * Class RequestMethodsTrait
 *
 * @package            BankID\SDK\Requests\Traits
 * @phan-file-suppress PhanAccessMethodInternal
 */
trait RequestMethodsTrait
{

    /**
     * @var RequestClient
     */
    protected $httpClient;

    /**
     * Asynchronous request.
     *
     * @param RequestInterface    $request
     * @param SerializerInterface $serializer
     * @return mixed
     */
    protected function request(RequestInterface $request, SerializerInterface $serializer)
    {
        // Execute the asynchronous request
        $promise = $this->httpClient->requestAsync($request);

        // Return a promise chain
        return $promise->then(function (HttpResponseInterface $response) use ($serializer): PromiseInterface {
            return $this->decode($response, $serializer);
        })->otherwise(function (Throwable $exception) use ($serializer): PromiseInterface {
            if (!$this->isValidResponse($exception)) {
                return rejection_for($exception);
            }

            // @phan-suppress-next-line PhanUndeclaredMethod
            return $this->decode($exception->getResponse(), $serializer);
        });
    }

    /**
     * Decode the response.
     *
     * @param HttpResponseInterface $response
     * @param SerializerInterface   $serializer
     * @return PromiseInterface
     */
    protected function decode(HttpResponseInterface $response, SerializerInterface $serializer)
    {
        // Compose a task, reject promise on failure
        return task(function () use ($response, $serializer): Envelope {
            // Queue the serialization
            return $serializer->decode($response);
        });
    }

    /**
     * Returns true if we retrieved a valid response, false otherwise.
     *
     * @param Throwable $exception
     * @return bool
     */
    protected function isValidResponse(Throwable $exception): bool
    {
        if (!$this->isRequestException($exception)) {
            return false;
        }

        // @phan-suppress-next-line PhanTypeMismatchArgument
        return $this->isResponseDefined($exception);
    }

    /**
     * Returns true if the exception is of request exception, false otherwise.
     *
     * @param Throwable $exception
     * @return bool
     */
    protected function isRequestException(Throwable $exception)
    {
        return $exception instanceof RequestException;
    }

    /**
     * Returns true if the response is defined, false otherwise.
     *
     * @param RequestException|null $exception
     * @return bool
     */
    protected function isResponseDefined(?RequestException $exception): bool
    {
        return $exception->getResponse() !== null;
    }
}
