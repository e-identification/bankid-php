<?php

namespace BankID\SDK\Requests\Payload\Serializers;

use Doctrine\Common\Annotations\AnnotationReader;
use BankID\SDK\Annotations\Base64Encoding;
use BankID\SDK\Annotations\Parameter;
use BankID\SDK\Requests\Payload\Interfaces\PayloadInterface;
use BankID\SDK\Requests\Payload\Interfaces\PayloadSerializerInterface;
use ReflectionClass;
use ReflectionProperty;

/**
 * Class PayloadSerializer
 *
 * @package BankID\SDK\Requests\Payload\Serializers
 */
class PayloadSerializer implements PayloadSerializerInterface
{

    protected const EMPTY_BODY = '';

    /**
     * @var AnnotationReader
     */
    protected $reader;

    /**
     * PayloadSerializer constructor.
     *
     * @param AnnotationReader $reader
     */
    public function __construct(AnnotationReader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Returns the encoded payload.
     *
     * @param PayloadInterface $subject
     * @return string
     */
    public function encode(PayloadInterface $subject): string
    {
        $class = new ReflectionClass($subject);

        $result = [];

        foreach ($class->getProperties() as $property) {
            $annotation = $this->getPropertyAnnotation($property, Parameter::class);

            if (($value = $this->getPropertyValue($property, $subject)) === null) {
                continue;
            }

            $result[$annotation->getAlias()] = $value;
        }

        return json_encode($result) ?: self::EMPTY_BODY;
    }

    /**
     * Returns the property annotation.
     *
     * @param ReflectionProperty $property
     * @param string             $annotation
     * @return Parameter|null
     */
    protected function getPropertyAnnotation(ReflectionProperty $property, $annotation)
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
     * @param PayloadInterface   $subject
     * @return mixed
     */
    protected function getPropertyValue(ReflectionProperty $property, PayloadInterface $subject)
    {
        $property->setAccessible(true);
        $value = $property->getValue($subject);

        if ($value === null) {
            return null;
        }

        if ($this->getPropertyAnnotation($property, Base64Encoding::class) === null) {
            return $value;
        }

        return base64_encode($value);
    }
}
