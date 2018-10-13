<?php

namespace BankID\SDK\Requests;

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
     * Request constructor.
     *
     * @param RequestClient $httpClient
     */
    public function __construct(RequestClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Executes the request.
     *
     * @return PromiseInterface
     */
    abstract public function fire(): PromiseInterface;
}
