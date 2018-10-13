<?php

namespace BankID\SDK\Requests\Payload;

/**
 * Class Requirement
 *
 * @package BankID\SDK\Requests\Payload
 */
class Requirement
{

    /**
     * @var string|null
     */
    protected $cardReader;

    /**
     * @var string|null
     */
    protected $certificatePolicies;

    /**
     * @var string|null
     */
    protected $issuerCn;

    /**
     * @var string|null
     */
    protected $autoStartTokenRequired;

    /**
     * @return null|string
     */
    public function getCardReader()
    {
        return $this->cardReader;
    }

    /**
     * @param string|null $cardReader
     * @return static
     */
    public function setCardReader(?string $cardReader)
    {
        $this->cardReader = $cardReader;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCertificatePolicies(): ?string
    {
        return $this->certificatePolicies;
    }

    /**
     * @param string|null $certificatePolicies
     * @return static
     */
    public function setCertificatePolicies(?string $certificatePolicies)
    {
        $this->certificatePolicies = $certificatePolicies;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIssuerCn(): ?string
    {
        return $this->issuerCn;
    }

    /**
     * @param string|null $issuerCn
     * @return static
     */
    public function setIssuerCn(?string $issuerCn)
    {
        $this->issuerCn = $issuerCn;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAutoStartTokenRequired(): ?string
    {
        return $this->autoStartTokenRequired;
    }

    /**
     * @param string|null $autoStartTokenRequired
     * @return static
     */
    public function setAutoStartTokenRequired(?string $autoStartTokenRequired)
    {
        $this->autoStartTokenRequired = $autoStartTokenRequired;
        return $this;
    }
}
