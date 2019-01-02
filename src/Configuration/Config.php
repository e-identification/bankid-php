<?php

declare(strict_types=1);

namespace BankID\SDK\Configuration;

use InvalidArgumentException;
use Webmozart\Assert\Assert;
use function BankID\SDK\ca_file;
use const BankID\SDK\ENVIRONMENT_PRODUCTION;
use const BankID\SDK\ENVIRONMENT_TEST;

/**
 * Class Config
 *
 * @package BankID\SDK\Configuration
 */
class Config
{

    public const ENVIRONMENT_PRODUCTION = 'production';

    /**
     * @var string
     */
    protected $environment = ENVIRONMENT_TEST;

    /**
     * @var string
     */
    protected $certificate;

    /**
     * @var string|null
     */
    protected $caCertificate;

    /**
     * Config constructor.
     *
     * @param string      $certificate The path to the PEM certificate file.
     * @param string      $environment
     * @param string|null $caCertification
     * @throws InvalidArgumentException
     */
    public function __construct(
        string $certificate,
        string $environment = ENVIRONMENT_TEST,
        ?string $caCertification = null
    ) {
        $this->environment = $environment;
        $this->certificate = $certificate;
        $this->caCertificate = $caCertification ?? ca_file(self::ENVIRONMENT_PRODUCTION);

        Assert::oneOf($environment, [ENVIRONMENT_TEST, ENVIRONMENT_PRODUCTION]);
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
