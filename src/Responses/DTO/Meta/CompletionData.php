<?php

declare(strict_types=1);

namespace BankID\SDK\Responses\DTO\Meta;

use Tebru\Gson\Annotation\SerializedName;

/**
 * Class CompletionData
 *
 * @IgnoreAnnotation("description")
 * @package BankID\SDK\Responses\DTO
 */
class CompletionData
{

    /**
     * Information related to the user, holds the following children.
     *
     * @var User
     */
    protected $user;

    /**
     * Information related to the device, holds the following child.
     *
     * @var Device
     */
    protected $device;

    /**
     * Information related to the certificate, holds the following children.
     *
     * @description
     * notBefore: Start the validity of the users BankID. Unix ms.
     * notAfter: End of validity of the Users BankID. Unix ms.
     *
     * @var Cert
     */
    protected $cert;

    /**
     * The signature.
     *
     * @description
     * The content of the signature is described in BankID Signature Profile specification.
     * Base64-encoded.
     *
     * @var string
     */
    protected $signature;

    /**
     * The OCSP response.
     *
     * @description
     * The OCSP response is signed by a certificate that has the name issuer as the certificate being verified.
     *
     * @SerializedName("ocspResponse")
     * @var string
     */
    protected $ocspResponse;

    /**
     * Returns the user.
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Returns the device.
     *
     * @return Device
     */
    public function getDevice(): Device
    {
        return $this->device;
    }

    /**
     * Returns the certificate.
     *
     * @return Cert
     */
    public function getCertificate(): Cert
    {
        return $this->cert;
    }

    /**
     * Returns the signature.
     *
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * Returns the ocsp response.
     *
     * @return string
     */
    public function getOcspResponse(): string
    {
        return $this->ocspResponse;
    }
}
