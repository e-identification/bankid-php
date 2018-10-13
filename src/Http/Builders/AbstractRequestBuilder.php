<?php

namespace BankID\SDK\Http\Builders;

use GuzzleHttp\Psr7\Request;

/**
 * Class AbstractRequestBuilder
 *
 * @package BankID\SDK\Http\Builders
 */
abstract class AbstractRequestBuilder
{

    /**
     * @var string The default method.
     */
    protected const METHOD_POST = 'POST';

    /**
     * @var string The test endpoint url
     */
    protected const ENDPOINT_TEST_URL = 'https://appapi2.test.bankid.com/rp/v5';

    /**
     * @var string The prod endpoint url
     */
    protected const ENDPOINT_PROD_URL = 'https://appapi2.bankid.com/rp/v5';

    /**
     * Builds HTTP request.
     *
     * @return Request
     */
    public function build(): Request
    {
        return new Request(
            $this->getMethod(),
            $this->getUri(),
            $this->getHeaders(),
            $this->getBody()
        );
    }

    /**
     * Returns the method type.
     *
     * @return string
     */
    protected function getMethod(): string
    {
        return self::METHOD_POST;
    }

    /**
     * Returns the default headers.
     *
     * @return array
     */
    protected function getHeaders(): array
    {
        // TODO, typehint the array

        return ['Content-Type' => 'application/json'];
    }

    /**
     * Returns the request full uri.
     *
     * @return string
     */
    abstract protected function getUri(): string;

    /**
     * Returns the payload.
     *
     * @return string|null
     */
    abstract protected function getBody(): ?string;
}
