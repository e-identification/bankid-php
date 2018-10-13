<?php

namespace BankID\SDK\Responses\DTO;

/**
 * Class Authentication
 *
 * @package BankID\SDK\Responses\DTO
 */
class Authentication extends Envelope
{

    /**
     * @var string|null
     */
    protected $orderRef;

    /**
     * @var string|null
     */
    protected $autoStartToken;

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
}
