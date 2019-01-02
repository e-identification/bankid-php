<?php

declare(strict_types=1);

namespace BankID\SDK\Http\Builders;

use BankID\SDK\Configuration\Config;
use BankID\SDK\Requests\Payload\Interfaces\PayloadInterface;
use BankID\SDK\Requests\Payload\Interfaces\PayloadSerializerInterface;
use BankID\SDK\Requests\Payload\Serializers\PayloadSerializer;
use Doctrine\Common\Annotations\Reader;
use ReflectionException;
use const BankID\SDK\ENVIRONMENT_PRODUCTION;

/**
 * Class GenericRequestBuilder
 *
 * @package BankID\SDK\Http\Builders
 * @internal
 */
class GenericRequestBuilder extends AbstractRequestBuilder
{

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var PayloadInterface The payload
     */
    protected $payload;

    /**
     * @var PayloadSerializerInterface
     */
    protected $serializer;

    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * GenericRequestBuilder constructor.
     *
     * @param string                          $uri
     * @param Config                          $config
     * @param Reader                          $annotationReader
     * @param PayloadSerializerInterface|null $serializer
     */
    public function __construct(
        string $uri,
        Config $config,
        Reader $annotationReader,
        ?PayloadSerializerInterface $serializer = null
    ) {
        $this->uri = $uri;
        $this->config = $config;
        $this->annotationReader = $annotationReader;
        $this->serializer = $serializer ?? new PayloadSerializer($annotationReader);
    }

    /**
     * Sets the payload.
     *
     * @param PayloadInterface $payload
     * @return GenericRequestBuilder
     */
    public function setPayload(PayloadInterface $payload): GenericRequestBuilder
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Returns the request full uri.
     *
     * @return string
     */
    protected function getUri(): string
    {
        $endpointUrl = self::ENDPOINT_TEST_URL;

        switch ($this->config->getEnvironment()) {
            case ENVIRONMENT_PRODUCTION:
                $endpointUrl = self::ENDPOINT_PROD_URL;

                break;
        }

        return \sprintf('%s/%s', $endpointUrl, $this->uri);
    }

    /**
     * Returns the payload.
     *
     * @return string|null
     * @throws ReflectionException
     */
    protected function getBody(): ?string
    {
        return $this->serializer->encode($this->payload);
    }
}
