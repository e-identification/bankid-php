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
     * MissingOptionsException constructor.
     *
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }
}
