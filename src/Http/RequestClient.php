<?php

namespace BankID\SDK\Http;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise\PromiseInterface;
use function GuzzleHttp\Promise\rejection_for;
use GuzzleHttp\Psr7\Request;
use BankID\SDK\Configuration\Config;
use BankID\SDK\Http\Handlers\ConfigHandler;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RequestClient
 *
 * @package BankID\SDK\Http
 */
class RequestClient
{

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * Client constructor.
     *
     * @param Config               $config
     * @param ClientInterface|null $client
     */
    public function __construct(Config $config, ?ClientInterface $client = null)
    {
        $this->config = $config;
        $this->client = $client ?? new Client();
    }

    /**
     * Sends the HTTP request.
     *
     * @param Request $request
     * @return ResponseInterface|null
     * @throws Exception
     */
    public function request(Request $request): ?ResponseInterface
    {
        $response = null;

        try {
            $response = $this->client->send($request, $this->options());
        } catch (ClientException $e) {
            // Retrieve the response envelope content
            $response = $e->getResponse();
        }

        return $response;
    }

    /**
     * Sends the HTTP request.
     *
     * @param RequestInterface $request
     * @return PromiseInterface
     * @throws Exception
     */
    public function requestAsync(RequestInterface $request): PromiseInterface
    {
        $response = null;

        try {
            $response = $this->client->sendAsync($request, $this->options());
        } catch (ClientException $e) {
            $response = rejection_for($e);
        }

        return $response;
    }

    /**
     * Returns the config.
     *
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @return array
     */
    protected function options(): array
    {
        $default = ['http_errors' => false];

        // TODO, typehint array

        return array_merge((new ConfigHandler())->asArray($this->config), $default);
    }
}
