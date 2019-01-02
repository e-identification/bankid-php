<?php

declare(strict_types=1);

namespace BankID\SDK\Requests\Payload;

use BankID\SDK\Annotations;
use BankID\SDK\Requests\Payload\Interfaces\PayloadInterface;
use BankID\SDK\Requests\Payload\Meta\RequirementMeta;
use BankID\SDK\Validators as BankIDAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AuthenticationPayload
 *
 * @package BankID\SDK\Requests\Payloads
 */
class SignPayload implements PayloadInterface
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
     * @Assert\NotBlank()
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
     * The text to be displayed and signed. The text can be formatted using CR, LF and CRLF for new lines.
     *
     * @Annotations\Base64Encoding
     * @Annotations\Parameter("userVisibleData")
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @BankIDAssert\Base64Length(
     *     length = 40000
     * )
     * @var string
     */
    protected $userVisibleData;

    /**
     * Data not displayed for the user.
     *
     * @Annotations\Base64Encoding
     * @Annotations\Parameter("userNonVisibleData")
     *
     * @BankIDAssert\Base64Length(
     *     length = 200000
     * )
     * @var string|null
     */
    protected $userNonVisibleData;

    /**
     * Requirements on how the auth or sign order must be performed.
     * @Annotations\Parameter("requirement")
     *
     * @var RequirementMeta|null
     */
    protected $requirement;

    /**
     * SignPayload constructor.
     *
     * @param string           $personalNumber
     * @param string           $endUserIp
     * @param string           $userVisibleData
     * @param RequirementMeta|null $requirement
     * @param null|string      $userNonVisibleData
     */
    public function __construct(
        string $personalNumber,
        string $endUserIp,
        string $userVisibleData,
        ?RequirementMeta $requirement = null,
        ?string $userNonVisibleData = null
    ) {
        $this->personalNumber = $personalNumber;
        $this->endUserIp = $endUserIp;
        $this->userVisibleData = $userVisibleData;
        $this->userNonVisibleData = $userNonVisibleData;
        $this->requirement = $requirement;
    }

    /**
     * Returns the user visible data.
     *
     * @return string
     */
    public function getUserVisibleData(): string
    {
        return $this->userVisibleData;
    }

    /**
     * Returns the user none visible data.
     *
     * @return string|null
     */
    public function getUserNonVisibleData(): ?string
    {
        return $this->userNonVisibleData;
    }
}
