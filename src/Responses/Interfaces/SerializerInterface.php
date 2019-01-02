<?php

declare(strict_types=1);

namespace BankID\SDK\Responses\Interfaces;

use BankID\SDK\Responses\DTO\Envelope;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

/**
 * Interface SerializerInterface
 *
 * @package BankID\SDK\Responses\Interfaces
 */
interface SerializerInterface
{

    /**
     * Decodes the response message.
     *
     * @param HttpResponseInterface $response
     * @return Envelope
     */
    public function decode(HttpResponseInterface $response): Envelope;
}
