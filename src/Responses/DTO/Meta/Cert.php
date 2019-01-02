<?php

declare(strict_types=1);

namespace BankID\SDK\Responses\DTO\Meta;

use Tebru\Gson\Annotation\SerializedName;

/**
 * Class Cert
 *
 * @package BankID\SDK\Responses\DTO
 */
class Cert
{

    /**
     * @SerializedName("notBefore")
     * @var string
     */
    protected $notBefore;

    /**
     * @SerializedName("notAfter")
     * @var string
     */
    protected $notAfter;

    /**
     * Returns the not before.
     *
     * @return string
     */
    public function getNotBefore(): string
    {
        return $this->notBefore;
    }

    /**
     * Returns the not after.
     *
     * @return string
     */
    public function getNotAfter(): string
    {
        return $this->notAfter;
    }
}
