<?php

declare(strict_types=1);

namespace BankID\SDK\Requests\Payload\Serializers;

use BankID\SDK\Annotations\Base64Encoding;
use BankID\SDK\Annotations\Parameter;
use BankID\SDK\Requests\Payload\Interfaces\PayloadInterface;
use BankID\SDK\Requests\Payload\Interfaces\PayloadSerializerInterface;
use Doctrine\Common\Annotations\Reader;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * Class PayloadSerializer
 *
 * @package            BankID\SDK\Requests\Payload\Serializers
 * @phan-file-suppress PhanAccessMethodInternal, PhanAccessClassConstantInternal
 */
class PayloadSerializer implements PayloadSerializerInterface
{

    protected const EMPTY_BODY = '';

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * PayloadSerializer constructor.
     *
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Returns the encoded payload.
     *
     * @param PayloadInterface $subject
     * @return string
     * @throws ReflectionException
     */
    public function encode(PayloadInterface $subject): string
    {
        $properties = $this->getPropertyValues($subject);

        return \json_encode($properties) ?: self::EMPTY_BODY;
    }

    /**
     * Returns the property values.
     *
     * @param PayloadInterface $subject
     * @return array
     * @throws ReflectionException
     */
    protected function getPropertyValues(PayloadInterface $subject): array
    {
        $result = [];
        $class = new ReflectionClass($subject);

        foreach ($class->getProperties() as $property) {
            if (($annotation = $this->getPropertyAnnotation($property, Parameter::class)) === null) {
                continue;
            }

            if (($value = $this->getPropertyValue($property, $subject)) === null) {
                continue;
            }

            $result[$annotation->getAlias()] = $value;
        }

        return $result;
    }


    /**
     * Returns the property annotation.
     *
     * @param ReflectionProperty $property
     * @param string $annotation
     * @return object|null
     */
    protected function getPropertyAnnotation(ReflectionProperty $property, string $annotation)
    {
        return $this->reader->getPropertyAnnotation(
            $property,
            $annotation
        );
    }

    /**
     * Returns the property value.
     *
     * @param ReflectionProperty $property
     * @param PayloadInterface $subject
     * @return mixed
     * @throws ReflectionException
     */
    protected function getPropertyValue(ReflectionProperty $property, PayloadInterface $subject)
    {
        $property->setAccessible(true);

        if (($value = $property->getValue($subject)) === null) {
            return null;
        }

        if ($value instanceof PayloadInterface) {
            return $this->getPropertyValues($value);
        }

        if ($this->getPropertyAnnotation($property, Base64Encoding::class) === null) {
            return $value;
        }

        return \base64_encode($value);
    }
}
