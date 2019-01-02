<?php

declare(strict_types=1);

namespace BankID\SDK;

use BankID\SDK\Configuration\Config;
use BankID\SDK\Exceptions\ValidationException;
use BankID\SDK\Requests\AuthenticationRequest;
use BankID\SDK\Requests\CancelRequest;
use BankID\SDK\Requests\CollectRequest;
use BankID\SDK\Requests\Payload\AuthenticationPayload;
use BankID\SDK\Requests\Payload\CancelPayload;
use BankID\SDK\Requests\Payload\CollectPayload;
use BankID\SDK\Requests\Payload\Interfaces\PayloadInterface;
use BankID\SDK\Requests\Payload\SignPayload;
use BankID\SDK\Requests\SignRequest;
use BankID\SDK\Responses\DTO\AuthenticationResponse;
use BankID\SDK\Responses\DTO\CancelResponse;
use BankID\SDK\Responses\DTO\CollectResponse;
use BankID\SDK\Responses\DTO\SignResponse;
use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Symfony\Component\Validator\Validation;
use function GuzzleHttp\Promise\task;

/**
 * Class ClientAsynchronous.
 *
 * @package            BankID\SDK
 * @phan-file-suppress PhanAccessMethodInternal
 */
class ClientAsynchronous
{

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Reader
     */
    protected $annotationReader;

    /**
     * Client constructor.
     *
     * @param Config $config
     * @param ClientInterface|null $client
     * @param Reader|null $annotationReader
     * @throws AnnotationException
     */
    public function __construct(Config $config, ?ClientInterface $client = null, ?Reader $annotationReader = null)
    {
        $this->config = $config;
        $this->client = $client ?? new GuzzleClient();
        $this->annotationReader = $annotationReader ?? new AnnotationReader();
    }

    /**
     * Initiates an authentication order.
     *
     * @description Use the collect method to query the status of the order.
     * If the request is successful, the orderRef and autoStartToken is returned.
     *
     * Returns @code RejectedPromise on @code Exception.
     *
     * @param AuthenticationPayload $payload
     * @return PromiseInterface<AuthenticationResponse>
     */
    public function authenticate(AuthenticationPayload $payload): PromiseInterface
    {
        return task(function () use ($payload): PromiseInterface {
            // @phan-suppress-next-line PhanThrowTypeAbsentForCall
            $this->validatePrerequisites($payload);

            return (new AuthenticationRequest($this, $payload))->fire();
        });
    }

    /**
     * Initiates an sign order.
     *
     * @description Use the collect method to query the status of the order.
     * If the request is successful, the orderRef and autoStartToken is returned.
     *
     * Returns @code RejectedPromise on @code Exception.
     *
     * @param SignPayload $payload
     * @return PromiseInterface<SignResponse>
     */
    public function sign(SignPayload $payload): PromiseInterface
    {
        return task(function () use ($payload): PromiseInterface {
            // @phan-suppress-next-line PhanThrowTypeAbsentForCall
            $this->validatePrerequisites($payload);

            return (new SignRequest($this, $payload))->fire();
        });
    }

    /**
     * Collects the result of a sign or auth order suing the orderRef as reference.
     *
     * @description
     * RP should keep calling collect every two seconds as long as status indicates pending.
     * RP must bort if status indicates failed. The user identity is returned when complete.
     *
     * Returns @code RejectedPromise on @code Exception.
     *
     * @param CollectPayload $payload
     * @return PromiseInterface<CollectResponse>
     */
    public function collect(CollectPayload $payload): PromiseInterface
    {
        return task(function () use ($payload): PromiseInterface {
            // @phan-suppress-next-line PhanThrowTypeAbsentForCall
            $this->validatePrerequisites($payload);

            return (new CollectRequest($this, $payload))->fire();
        });
    }

    /**
     * Cancels an ongoing sign or auth order.
     *
     * @description
     * This is typically used if the user cancels the order in your service or app.
     * @param CancelPayload $payload
     *
     * Returns @code RejectedPromise on @code Exception.
     *
     * @return PromiseInterface<CancelResponse>
     */
    public function cancel(CancelPayload $payload): PromiseInterface
    {
        return task(function () use ($payload): PromiseInterface {
            // @phan-suppress-next-line PhanThrowTypeAbsentForCall
            $this->validatePrerequisites($payload);

            return (new CancelRequest($this, $payload))->fire();
        });
    }

    /**
     * Returns the client configuration.
     *
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * Returns the HTTP client.
     *
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * Returns the annotation reader.
     *
     * @return Reader
     */
    public function getAnnotationReader(): Reader
    {
        return $this->annotationReader;
    }

    /**
     * Validates the prerequisites, mainly the payload integrity.
     *
     * @param PayloadInterface $payload
     * @throws ValidationException
     * @throws AnnotationException
     */
    protected function validatePrerequisites(PayloadInterface $payload): void
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping($this->annotationReader)
            ->getValidator();

        $errors = $validator->validate($payload);

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }
}
