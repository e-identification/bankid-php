<?php

declare(strict_types=1);

namespace BankID\SDK\Requests\Traits;

use BankID\SDK\Configuration\Config;
use BankID\SDK\Http\Handlers\ConfigHandler;
use BankID\SDK\Responses\DTO\Envelope;
use BankID\SDK\Responses\Interfaces\SerializerInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
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
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Asynchronous request.
     *
     * @param RequestInterface    $request
     * @param SerializerInterface $serializer
     * @return PromiseInterface
     */
    protected function request(RequestInterface $request, SerializerInterface $serializer): PromiseInterface
    {
        // Execute the asynchronous request
        $promise = $this->requestAsync($request);

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
     * Sends the HTTP request.
     *
     * @param RequestInterface $request
     * @return PromiseInterface
     */
    protected function requestAsync(RequestInterface $request): PromiseInterface
    {
        $response = null;

        try {
            $response = $this->httpClient->sendAsync($request, $this->options());
        } catch (ClientException | Throwable $e) {
            $response = rejection_for($e);
        }

        return $response;
    }

    /**
     * Returns the curl options.
     *
     * @return array
     */
    protected function options(): array
    {
        $default = ['http_errors' => false];

        return array_merge((new ConfigHandler())->asArray($this->config), $default);
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
