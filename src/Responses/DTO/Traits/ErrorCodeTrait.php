<?php

namespace BankID\SDK\Responses\DTO\Traits;

trait ErrorCodeTrait
{

    /**
     * @var string|null
     */
    protected $errorCode;

    /**
     * Returns true if already in progress, false otherwise.
     * @return bool
     */
    public function isAlreadyInProgress(): bool
    {
        return $this->errorCode === self::ERROR_CODE_ALREADY_IN_PROGRESS;
    }
}
