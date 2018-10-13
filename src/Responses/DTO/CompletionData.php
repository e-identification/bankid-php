<?php

namespace BankID\SDK\Responses\DTO;

/**
 * Class CompletionData
 *
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
     * The OCSP response  is signed by a certificate that has the name issuer as the certificate being verified.
     *
     * @var string
     */
    protected $ocspResponse;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Device
     */
    public function getDevice(): Device
    {
        return $this->device;
    }

    /**
     * @return Cert
     */
    public function getCert(): Cert
    {
        return $this->cert;
    }

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * @return string
     */
    public function getOcspResponse(): string
    {
        return $this->ocspResponse;
    }
}
