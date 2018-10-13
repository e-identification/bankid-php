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
     * @return string|null
     */
    public function getOrderRef(): ?string
    {
        return $this->orderRef;
    }

    /**
     * @return string|null
     */
    public function getAutoStartToken(): ?string
    {
        return $this->autoStartToken;
    }
}
