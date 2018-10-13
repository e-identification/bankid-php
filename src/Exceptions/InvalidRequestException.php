<?php

namespace BankID\SDK\Exceptions;

use Exception;

/**
 * Class InvalidRequestException
 *
 * @package BankID\SDK\Exceptions
 */
class InvalidRequestException extends Exception
{

    /**
     * @var string
     */
    protected $payload;

    /**
     * InvalidRequestException constructor.
     *
     * @param string $payload
     */
    public function __construct(string $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }
}
