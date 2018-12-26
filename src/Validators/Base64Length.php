<?php

namespace BankID\SDK\Validators;

use BankID\SDK\Exceptions\MissingOptionsException;
use Symfony\Component\Validator\Constraint;

/**
 * Class Base64Length
 *
 * @Annotation
 * @package BankID\SDK\Validators
 * @internal
 */
class Base64Length extends Constraint
{

    /**
     * Error message
     *
     * @var string
     */
    public $message = "The string is to long when encoded as base64.";

    /**
     * @var ?int
     */
    protected $length;

    /**
     * Base64Length constructor.
     *
     * @param array $options
     * @throws MissingOptionsException
     */
    public function __construct(array $options)
    {
        parent::__construct($options);

        // TODO, typehint array

        if ($options['length']) {
            $this->length = $options['length'];
        } else {
            throw new MissingOptionsException("Option missing in Base64Length constraint.");
        }
    }

    /**
     * The length
     *
     * @return int|null
     */
    public function getLength(): ?int
    {
        return $this->length;
    }

    /**
     * @return string
     */
    public function validatedBy()
    {
        return Base64LengthValidator::class;
    }
}
