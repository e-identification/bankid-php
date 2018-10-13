<?php

namespace BankID\SDK\Requests\Payload;

use BankID\SDK\Annotations;
use BankID\SDK\Requests\Payload\Interfaces\PayloadInterface;

/**
 * Class AuthenticationPayload
 *
 * @package BankID\SDK\Requests\Payloads
 */
class CollectPayload implements PayloadInterface
{
    /**
     * The orderRef from the response from @code authentication or @code sign.
     *
     * @Annotations\Parameter("orderRef")
     *
     * @var string
     */
    protected $orderRef;

    public function __construct(string $orderRef)
    {
        $this->orderRef = $orderRef;
    }

    /**
     * @return string
     */
    public function getOrderRef(): string
    {
        return $this->orderRef;
    }
}
