<?php

declare(strict_types=1);

namespace BankID\SDK\Requests\Payload\Interfaces;

/**
 * Interface PayloadSerializerInterface
 *
 * @package BankID\SDK\Requests\Payload\Interfaces
 */
interface PayloadSerializerInterface
{

    /**
     * Returns the encoded payload.
     *
     * @param PayloadInterface $subject
     * @return string
     */
    public function encode(PayloadInterface $subject): string;
}
