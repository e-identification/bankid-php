<?php

declare(strict_types=1);

namespace BankID\SDK\Responses\DTO\Meta;

use Tebru\Gson\Annotation\SerializedName;

/**
 * Class Device
 *
 * @package BankID\SDK\Responses\DTO
 */
class Device
{

    /**
     * @SerializedName("ipAddress")
     * @var string
     */
    protected $ipAddress;

    /**
     * Returns the ip address.
     *
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }
}
