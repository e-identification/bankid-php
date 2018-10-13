<?php

namespace BankID\SDK\Responses\DTO;

/**
 * Class Device
 *
 * @package BankID\SDK\Responses\DTO
 */
class Device
{

    /**
     * @var string
     */
    protected $ipAddress;

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }
}
