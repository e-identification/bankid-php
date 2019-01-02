<?php

declare(strict_types=1);

namespace BankID\SDK\Responses\DTO\Traits;

use const BankID\SDK\Responses\ERROR_CODE_ALREADY_IN_PROGRESS;

/**
 * Trait ErrorCodeTrait
 *
 * @package BankID\SDK\Responses\DTO\Traits
 * @phan-file-suppress PhanUndeclaredConstant
 */
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
        return $this->errorCode === ERROR_CODE_ALREADY_IN_PROGRESS;
    }
}
