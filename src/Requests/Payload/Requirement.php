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
     * Returns the card reader.
     *
     * @return string|null
     */
    public function getCardReader()
    {
        return $this->cardReader;
    }

    /**
     * Sets the card reader.
     *
     * @param string|null $cardReader
     * @return static
     */
    public function setCardReader(?string $cardReader)
    {
        $this->cardReader = $cardReader;
        return $this;
    }

    /**
     * Returns the certificate policies.
     *
     * @return string|null
     */
    public function getCertificatePolicies(): ?string
    {
        return $this->certificatePolicies;
    }

    /**
     * Sets the certificate policies.
     *
     * @param string|null $certificatePolicies
     * @return static
     */
    public function setCertificatePolicies(?string $certificatePolicies)
    {
        $this->certificatePolicies = $certificatePolicies;
        return $this;
    }

    /**
     * Returns the issuer cn.
     *
     * @return string|null
     */
    public function getIssuerCn(): ?string
    {
        return $this->issuerCn;
    }

    /**
     * Sets the issuer cn.
     *
     * @param string|null $issuerCn
     * @return static
     */
    public function setIssuerCn(?string $issuerCn)
    {
        $this->issuerCn = $issuerCn;
        return $this;
    }

    /**
     * Returns the auto start token required.
     *
     * @return string|null
     */
    public function getAutoStartTokenRequired(): ?string
    {
        return $this->autoStartTokenRequired;
    }

    /**
     * Sets the auto start token required.
     *
     * @param string|null $autoStartTokenRequired
     * @return static
     */
    public function setAutoStartTokenRequired(?string $autoStartTokenRequired)
    {
        $this->autoStartTokenRequired = $autoStartTokenRequired;
        return $this;
    }
}
