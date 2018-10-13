<?php

namespace BankID\SDK\Responses\DTO;

use BankID\SDK\Responses\DTO\Traits\ErrorCodeTrait;
use Traits\MappableTrait;

/**
 * Class Envelope
 *
 * @package BankID\SDK\Responses\DTO
 */
abstract class Envelope
{

    use MappableTrait;
    use ErrorCodeTrait;

    public const ERROR_CODE_ALREADY_IN_PROGRESS = 'alreadyInProgress';
    public const ERROR_CODE_INVALID_PARAMETERS = 'invalidParameters';
    public const ERROR_CODE_UNAUTHORIZED = 'unauthorized';
    public const ERROR_CODE_NOT_FOUND = 'notFound';
    public const ERROR_CODE_REQUEST_TIMEOUT = 'requestTimeout';
    public const ERROR_CODE_UNSUPPORTED_MEDIA_TYPE = 'unsupportedMediaType';
    public const ERROR_CODE_INTERNAL_ERROR = 'internalError';
    public const ERROR_CODE_MAINTENANCE = 'Maintenance';

    /**
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
