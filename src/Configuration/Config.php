<?php

namespace BankID\SDK\Configuration;

use Webmozart\Assert\Assert;

/**
 * Class Config
 *
 * @package BankID\SDK\Configuration
 */
class Config
{

    public const ENVIRONMENT_TEST = 'test';
    public const ENVIRONMENT_PRODUCTION = 'production';

    /**
     * @var string
     */
    protected $environment = self::ENVIRONMENT_TEST;

    /**
     * @var string|null
     */
    protected $certificate;

    /**
     * @var string|null
     */
    protected $caCertificate;

    /**
     * Config constructor.
     * @param string $environment
     * @param string|null $certificate
     * @param string|null $caCert
     */
    public function __construct(
        string $environment = self::ENVIRONMENT_TEST,
        ?string $certificate = null,
        ?string $caCert = null
    ) {
        $this->environment = $environment;
        $this->certificate = $certificate;
        $this->caCertificate = $caCert;

        Assert::oneOf($environment, [self::ENVIRONMENT_TEST, self::ENVIRONMENT_PRODUCTION]);
    }

    /**
     * Returns the environment.
     *
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * Returns the path to the certificate.
     *
     * @return string|null
     */
    public function getCertificate(): ?string
    {
        return $this->certificate;
    }

    /**
     * Returns true if the certificate is defined, false otherwise.
     *
     * @return bool
     */
    public function isCertificateDefined(): bool
    {
        return $this->certificate !== null;
    }

    /**
     * Returns the path to the CA certificate.
     *
     * @return string|null
     */
    public function getCaCertificate(): ?string
    {
        return $this->caCertificate;
    }

    /**
     * Returns true if the CA certificate is defined, false otherwise.
     *
     * @return bool
     */
    public function isCaCertificateDefined(): bool
    {
        return $this->caCertificate !== null;
    }
}
