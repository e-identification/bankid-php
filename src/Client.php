<?php

namespace BankID\SDK;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use GuzzleHttp\Promise\PromiseInterface;
use BankID\SDK\Exceptions\ValidationException;
use BankID\SDK\Http\RequestClient;
use BankID\SDK\Requests\AuthenticationRequest;
use BankID\SDK\Requests\CancelRequest;
use BankID\SDK\Requests\CollectRequest;
use BankID\SDK\Requests\Payload\AuthenticationPayload;
use BankID\SDK\Requests\Payload\CancelPayload;
use BankID\SDK\Requests\Payload\CollectPayload;
use BankID\SDK\Requests\Payload\Interfaces\PayloadInterface;
use BankID\SDK\Requests\Payload\SignPayload;
use BankID\SDK\Requests\SignRequest;
use Symfony\Component\Validator\Validation;
use function GuzzleHttp\Promise\task;

/**
 * Class Client
 *
 * @package BankID\SDK
 */
class Client
{

    /**
     * @var RequestClient
     */
    protected $requestClient;

    /**
     * Client constructor.
     *
     * @param RequestClient $requestClient
     */
    public function __construct(RequestClient $requestClient)
    {
        $this->requestClient = $requestClient;
    }

    /**
     * Initiates an authentication order.
     *
     * @description Use the collect method to query the status of the order.
     * If the request is successful, the orderRef and autoStartToken is returned.
     *
     * @param AuthenticationPayload $payload
     * @return PromiseInterface
     */
    public function authenticate(AuthenticationPayload $payload): PromiseInterface
    {
        return task(function () use ($payload): PromiseInterface {
            // @phan-suppress-next-line PhanThrowTypeAbsentForCall
            $this->validatePrerequisites($payload);

            return (new AuthenticationRequest($this->requestClient, $payload))->fire();
        });
    }

    /**
     * Initiates an sign order.
     *
     * @description Use the collect method to query the status of the order.
     * If the request is successful, the orderRef and autoStartToken is returned.
     *
     * @param SignPayload $payload
     * @return PromiseInterface
     */
    public function sign(SignPayload $payload): PromiseInterface
    {
        return task(function () use ($payload): PromiseInterface {
            // @phan-suppress-next-line PhanThrowTypeAbsentForCall
            $this->validatePrerequisites($payload);

            return (new SignRequest($this->requestClient, $payload))->fire();
        });
    }

    /**
     * Collects the result of a sign or auth order suing the orderRef as reference.
     *
     * @description
     * RP should keep calling collect every two seconds as long as status indicates pending.
     * RP must bort if status indicates failed. The user identity is returned when complete.
     *
     * @param CollectPayload $payload
     * @return PromiseInterface
     */
    public function collect(CollectPayload $payload): PromiseInterface
    {
        return task(function () use ($payload): PromiseInterface {
            // @phan-suppress-next-line PhanThrowTypeAbsentForCall
            $this->validatePrerequisites($payload);

            return (new CollectRequest($this->requestClient, $payload))->fire();
        });
    }

    /**
     * Cancels an ongoing sign or auth order.
     *
     * @description
     * This is typically used if the user cancels the order in your service or app.
     *
     * @param $payload
     * @return PromiseInterface
     */
    public function cancel(CancelPayload $payload): PromiseInterface
    {
        return task(function () use ($payload): PromiseInterface {
            // @phan-suppress-next-line PhanThrowTypeAbsentForCall
            $this->validatePrerequisites($payload);

            return (new CancelRequest($this->requestClient, $payload))->fire();
        });
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
            ->enableAnnotationMapping(new AnnotationReader())
            ->getValidator();

        $errors = $validator->validate($payload);

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }
}
