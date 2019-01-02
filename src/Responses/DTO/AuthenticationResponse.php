<?php

declare(strict_types=1);

namespace BankID\SDK\Responses\DTO;

use BankID\SDK\ClientAsynchronous;
use BankID\SDK\Requests\Payload\CancelPayload;
use BankID\SDK\Requests\Payload\CollectPayload;
use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use Tebru\Gson\Annotation\SerializedName;
use function GuzzleHttp\Promise\rejection_for;

/**
 * Class Authentication
 *
 * @package BankID\SDK\Responses\DTO
 */
class AuthenticationResponse extends Envelope
{

    /**
     * @SerializedName("orderRef")
     * @var string|null
     */
    protected $orderRef;

    /**
     * @SerializedName("autoStartToken")
     * @var string|null
     */
    protected $autoStartToken;

    /**
     * @var ClientAsynchronous
     */
    protected $client;

    /**
     * Authentication constructor.
     *
     * @param ClientAsynchronous $client
     */
    public function __construct(ClientAsynchronous $client)
    {
        $this->client = $client;
    }

    /**
     * Returns the order reference.
     *
     * @return string|null
     */
    public function getOrderRef(): ?string
    {
        return $this->orderRef;
    }

    /**
     * Returns the auto start token.
     *
     * @return string|null
     */
    public function getAutoStartToken(): ?string
    {
        return $this->autoStartToken;
    }

    /**
     * Collects the result of a sign or auth order suing the orderRef as reference.
     *
     * @return PromiseInterface
     */
    public function collect(): PromiseInterface
    {
        if (!$this->isSuccess()) {
            return rejection_for(new Exception(sprintf(
                'Action not possible. Order reference invalid. Possible cause: %s',
                $this->getDetails()
            )));
        }

        return $this->client->collect(new CollectPayload($this->orderRef));
    }

    /**
     * Cancels an ongoing sign or auth order.
     *
     * @return PromiseInterface
     */
    public function cancel(): PromiseInterface
    {
        if (!$this->isSuccess()) {
            return rejection_for(new Exception(sprintf(
                'Action not possible. Order reference invalid. Possible cause: %s',
                $this->getDetails()
            )));
        }

        return $this->client->cancel(new CancelPayload($this->orderRef));
    }
}
