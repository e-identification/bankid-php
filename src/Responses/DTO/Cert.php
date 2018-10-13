<?php

namespace BankID\SDK\Responses\DTO;

/**
 * Class Cert
 *
 * @package BankID\SDK\Responses\DTO
 */
class Cert
{

    /**
     * @var string
     */
    protected $notBefore;

    /**
     * @var string
     */
    protected $notAfter;

    /**
     * @return string
     */
    public function getNotBefore(): string
    {
        return $this->notBefore;
    }

    /**
     * @return string
     */
    public function getNotAfter(): string
    {
        return $this->notAfter;
    }
}
