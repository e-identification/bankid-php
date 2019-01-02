<?php

declare(strict_types=1);

namespace BankID\SDK\Responses\DTO;

use BankID\SDK\Responses\DTO\Traits\ErrorCodeTrait;
use Tebru\Gson\Annotation\SerializedName;
use Traits\MappableTrait;

/**
 * Class Envelope
 *
 * @package BankID\SDK\Responses\DTO
 */
abstract class Envelope
{

    use ErrorCodeTrait;

    /**
     * @SerializedName("errorCode")
     * @var string|null
     */
    protected $errorCode;

    /**
     * @var string|null
     */
    protected $details;

    /**
     * Returns the error code.
     *
     * @return string|null
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Returns the details.
     *
     * @return null|string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Returns true if the request was successful, false otherwise.
     *
     * @return bool
     */
    public function isSuccess()
    {
        return $this->errorCode === null;
    }
}
