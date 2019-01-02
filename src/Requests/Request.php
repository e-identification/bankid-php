<?php

declare(strict_types=1);

namespace BankID\SDK\Requests;

use BankID\SDK\Configuration\Config;
use BankID\SDK\Requests\Traits\RequestMethodsTrait;
use Doctrine\Common\Annotations\Reader;
use GuzzleHttp\ClientInterface;
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
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var Reader
     */
    protected $annotationReader;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Request constructor.
     *
     * @param ClientInterface $httpClient
     * @param Reader          $annotationReader
     * @param Config          $config
     */
    public function __construct(ClientInterface $httpClient, Reader $annotationReader, Config $config)
    {
        $this->httpClient = $httpClient;
        $this->annotationReader = $annotationReader;
        $this->config = $config;
    }

    /**
     * Executes the request.
     *
     * @return PromiseInterface
     */
    abstract public function fire(): PromiseInterface;
}
