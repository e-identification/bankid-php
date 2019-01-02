<?php

declare(strict_types=1);

namespace BankID\SDK\Requests\Payload\Meta;

use BankID\SDK\Annotations;
use BankID\SDK\Requests\Payload\Interfaces\PayloadInterface;

/**
 * Class Requirement
 *
 * @package BankID\SDK\Requests\Payload\Meta
 */
class RequirementMeta implements PayloadInterface
{

    /**
     * @Annotations\Parameter("cardReader")
     * @var string|null
     */
    protected $cardReader;

    /**
     * @Annotations\Parameter("certificatePolicies")
     * @var string|null
     */
    protected $certificatePolicies;

    /**
     * @Annotations\Parameter("issuerCn")
     * @var string|null
     */
    protected $issuerCn;

    /**
     * @Annotations\Parameter("autoStartTokenRequired")
     * @var bool|null
     */
    protected $autoStartTokenRequired;

    /**
     * @Annotations\Parameter("allowFingerprint")
     * @var bool|null
     */
    protected $allowFingerprint;

    /**
     * Requirement constructor.
     *
     * @param string|null $cardReader
     * @param string|null $certificatePolicies
     * @param string|null $issuerCn
     * @param bool|null $autoStartTokenRequired
     * @param bool|null $allowFingerprint
     */
    public function __construct(?string $cardReader = null, ?string $certificatePolicies = null, ?string $issuerCn = null, ?bool $autoStartTokenRequired = null, ?bool $allowFingerprint = null)
    {
        $this->cardReader = $cardReader;
        $this->certificatePolicies = $certificatePolicies;
        $this->issuerCn = $issuerCn;
        $this->autoStartTokenRequired = $autoStartTokenRequired;
        $this->allowFingerprint = $allowFingerprint;
    }


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
     * Returns the certificate policies.
     *
     * @return string|null
     */
    public function getCertificatePolicies(): ?string
    {
        return $this->certificatePolicies;
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
     * Returns the auto start token required.
     *
     * @return bool|null
     */
    public function getAutoStartTokenRequired(): ?bool
    {
        return $this->autoStartTokenRequired;
    }

    /**
     * Returns the allow fingerprint.
     *
     * @return bool|null
     */
    public function getAllowFingerprint(): ?bool
    {
        return $this->allowFingerprint;
    }
}
