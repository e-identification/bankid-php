<?php

declare(strict_types=1);

namespace BankID\SDK\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class Base64LengthValidator
 *
 * @package BankID\SDK\Validators
 * @internal
 */
class Base64LengthValidator extends ConstraintValidator
{

    /**
     * Validates the length of encoded base64 strings.
     *
     * @param string|null $value
     * @param Constraint  $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        // Check whether we retrieved a valid value to be validated. Null or empty string will be skipped
        if ($this->isStringToBeValidated($value)) {
            return;
        }

        $based = \base64_encode($value);

        if (!($constraint instanceof Base64Length)) {
            return;
        }

        /** @var Base64Length $constraint */
        $length = $constraint->getLength();

        if (\strlen($based) > $length) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }


    /**
     * Return true if the string is to be validated, false otherwise.
     * Null or empty string should not be validated.
     *
     * @param string|null $value
     * @return bool
     */
    protected function isStringToBeValidated(?string $value): bool
    {
        return $value == null;
    }
}
