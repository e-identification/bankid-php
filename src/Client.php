<?php

declare(strict_types=1);

namespace BankID\SDK;

use BankID\SDK\Configuration\Config;
use BankID\SDK\Requests\Payload\AuthenticationPayload;
use BankID\SDK\Requests\Payload\CancelPayload;
use BankID\SDK\Requests\Payload\CollectPayload;
use BankID\SDK\Requests\Payload\SignPayload;
use BankID\SDK\Responses\DTO\AuthenticationResponse;
use BankID\SDK\Responses\DTO\CancelResponse;
use BankID\SDK\Responses\DTO\CollectResponse;
use BankID\SDK\Responses\DTO\SignResponse;
use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\Reader;
use Exception;
use GuzzleHttp\ClientInterface;

/**
 * Class Client.
 * Proxy class for @code ClientAsynchronous.
 *
 * @package            BankID\SDK
 * @phan-file-suppress PhanAccessMethodInternal
 */
class Client
{

    /**
     * @var ClientAsynchronous
     */
    protected $client;

    /**
     * ClientAsynchronous constructor.
     *
     * @param Config $config
     * @param ClientInterface|null $client
     * @param Reader|null $annotationReader
     * @throws AnnotationException
     */
    public function __construct(Config $config, ?ClientInterface $client = null, ?Reader $annotationReader = null)
    {
        $this->client = new ClientAsynchronous($config, $client, $annotationReader);
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
     * @return AuthenticationResponse
     * @throws Exception
     */
    public function authenticate(AuthenticationPayload $payload): AuthenticationResponse
    {
        return $this->client->authenticate($payload)->wait(true);
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
     * @return SignResponse
     * @throws Exception
     */
    public function sign(SignPayload $payload): SignResponse
    {
        return $this->client->sign($payload)->wait(true);
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
     * @return CollectResponse
     * @throws Exception
     */
    public function collect(CollectPayload $payload): CollectResponse
    {
        return $this->client->collect($payload)->wait(true);
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
     * @return CancelResponse
     * @throws Exception
     */
    public function cancel(CancelPayload $payload): CancelResponse
    {
        return $this->client->cancel($payload)->wait(true);
    }
}
