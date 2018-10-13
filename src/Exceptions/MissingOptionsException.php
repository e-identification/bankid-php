<?php

namespace BankID\SDK\Exceptions;

use Exception;

/**
 * Class MissingOptionsException
 *
 * @package BankID\SDK\Exceptions
 */
class MissingOptionsException extends Exception
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
