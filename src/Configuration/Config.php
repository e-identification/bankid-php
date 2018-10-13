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
    protected $caCert;

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
        $this->caCert = $caCert;

        Assert::oneOf($environment, [self::ENVIRONMENT_TEST, self::ENVIRONMENT_PRODUCTION]);
    }

    /**
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * @return string|null
     */
    public function getCertificate(): ?string
    {
        return $this->certificate;
    }

    /**
     * @return bool
     */
    public function isCertificateDefined(): bool
    {
        return $this->certificate !== null;
    }

    /**
     * @return string|null
     */
    public function getCaCert(): ?string
    {
        return $this->caCert;
    }

    /**
     * @return bool
     */
    public function isCaCertDefined(): bool
    {
        return $this->caCert !== null;
    }
}
