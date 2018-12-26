<?php

namespace BankID\SDK\Requests;

use BankID\SDK\Http\RequestClient;
use BankID\SDK\Requests\Traits\RequestMethodsTrait;
use Doctrine\Common\Annotations\Reader;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Class Request
 *
 * @package            BankID\SDK\Requests
 * @internal
 * @phan-file-suppress PhanAccessMethodInternal
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
