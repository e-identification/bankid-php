<?php

namespace BankID\SDK\Requests\Payload;

use BankID\SDK\Annotations;
use BankID\SDK\Requests\Payload\Interfaces\PayloadInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AuthenticationPayload
 *
 * @package BankID\SDK\Requests\Payloads
 */
class AuthenticationPayload implements PayloadInterface
{

    /**
     * The personal number of the user. String 12 digits. Century must be included.
     * If the personal number is excluded, the client must be started with
     * the @code autoStartToken returned in the response.
     * @Annotations\Parameter("personalNumber")
     * @Assert\Length(
     *      exactMessage = "Personal number is not valid, must be exactly 12 digits",
     *      min = 12,
     *      max = 12
     * )
     * @Assert\Regex(
     *     pattern="/\d+/",
     *     match=true,
     *     message="Your personal number cannot contain a number"
     * )
     * @var string
     */
    protected $personalNumber;

    /**
     * The user IP address as seen by RP. String, IPv4 and IPv6 is allowed.
     * @Annotations\Parameter("endUserIp")
     * @Assert\Ip(
     *     version = "all"
     * )
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @var string
     */
    protected $endUserIp;

    /**
     * Requirements on how the auth or sign order must be performed.
     * @Annotations\Parameter("requirement")
     *
     * @var Requirement|null
     */
    protected $requirement;

    public function __construct(string $personalNumber, string $endUserIp, ?Requirement $requirement = null)
    {
        $this->personalNumber = $personalNumber;
        $this->endUserIp = $endUserIp;
        $this->requirement = $requirement;
    }

    /**
     * Returns the personal number.
     *
     * @return string
     */
    public function getPersonalNumber(): string
    {
        return $this->personalNumber;
    }

    /**
     * Returns the end user IP.
     *
     * @return string
     */
    public function getEndUserIp(): string
    {
        return $this->endUserIp;
    }

    /**
     * Returns the requirement.
     *
     * @return Requirement|null
     */
    public function getRequirement(): ?Requirement
    {
        return $this->requirement;
    }
}
