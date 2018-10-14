<?php

namespace BankID\SDK\Requests;

use Doctrine\Common\Annotations\Reader;
use GuzzleHttp\Promise\PromiseInterface;
use BankID\SDK\Http\RequestClient;
use BankID\SDK\Requests\Traits\RequestMethodsTrait;

/**
 * Class Request
 *
 * @package BankID\SDK\Requests
 */
abstract class Request
{

    use RequestMethodsTrait;

    /**
     * @var RequestClient
     */
    protected $httpClient;

    /**
     * @var Reader
     */
    protected $annotationReader;

    /**
     * Request constructor.
     *
     * @param RequestClient $httpClient
     * @param Reader        $annotationReader
     */
    public function __construct(RequestClient $httpClient, Reader $annotationReader)
    {
        $this->httpClient = $httpClient;
        $this->annotationReader = $annotationReader;
    }

    /**
     * Executes the request.
     *
     * @return PromiseInterface
     */
    abstract public function fire(): PromiseInterface;
}
