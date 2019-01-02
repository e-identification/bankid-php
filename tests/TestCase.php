<?php

namespace BankID\SDK\Tests;

use BankID\SDK\Exceptions\ValidationException;
use Exception;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class TestCase extends \PHPUnit\Framework\TestCase
{

    /**
     * Returns mocked validation exception.
     *
     * @param string $message
     * @param string $propertyPath
     * @return ValidationException
     */
    protected function getMockedValidationException(string $message, string $propertyPath): ValidationException
    {
        return new ValidationException(new ConstraintViolationList(
            [
                new ConstraintViolation(
                    $message,
                    null,
                    [],
                    null,
                    $propertyPath,
                    null
                )
            ]
        ));
    }

    /**
     * Validates exceptions.
     *
     * @param Exception $subject
     * @param Exception $target
     * @return void
     */
    protected function assertExceptionsEqual(Exception $subject, Exception $target): void
    {
        $this->assertEquals(\get_class($subject), \get_class($target));
        $this->assertEquals($subject->getMessage(), $target->getMessage());
        $this->assertEquals($subject->getCode(), $target->getCode());
    }
}
