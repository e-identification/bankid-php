<?php

namespace BankID\SDK\Http\Builders;

use Doctrine\Common\Annotations\AnnotationReader;
use BankID\SDK\Configuration\Config;
use BankID\SDK\Requests\Payload\Interfaces\PayloadInterface;
use BankID\SDK\Requests\Payload\Interfaces\PayloadSerializerInterface;
use BankID\SDK\Requests\Payload\Serializers\PayloadSerializer;

/**
 * Class GenericRequestBuilder
 *
 * @package BankID\SDK\Http\Builders
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
     * GenericRequestBuilder constructor.
     *
     * @param string                          $uri
     * @param Config                          $config
     * @param PayloadSerializerInterface|null $serializer
     */
    public function __construct(string $uri, Config $config, ?PayloadSerializerInterface $serializer = null)
    {
        $this->uri = $uri;
        $this->config = $config;

        // TODO, should be possible to pass annotation reader, possible the payload serializer

        $this->serializer = $serializer ?? new PayloadSerializer(new AnnotationReader());
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
            case Config::ENVIRONMENT_PRODUCTION:
                $endpointUrl = self::ENDPOINT_PROD_URL;

                break;
        }

        return sprintf('%s/%s', $endpointUrl, $this->uri);
    }

    /**
     * Returns the payload.
     *
     * @return string|null
     */
    protected function getBody(): ?string
    {
        return $this->serializer->encode($this->payload);
    }
}
