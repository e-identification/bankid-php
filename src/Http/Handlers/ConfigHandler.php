<?php

namespace BankID\SDK\Http\Handlers;

use BankID\SDK\Configuration\Config;

/**
 * Class ConfigHandler
 *
 * @package BankID\SDK\Http\Handlers
 */
class ConfigHandler
{

    /**
     * Turns the the configuration into a array.
     *
     * @param Config $config
     * @return array
     */
    public function asArray(Config $config): array
    {
        $array = [];

        // TODO, typehint array

        $this->addCertificateFileIfExists($array, $config);
        $this->addCaCertFileIfExists($array, $config);

        return $array;
    }

    /**
     * Adds the certificate file if exists.
     *
     * @param array  $result
     * @param Config $config
     * @return void
     */
    protected function addCertificateFileIfExists(array &$result, Config $config)
    {
        if (!$config->isCertificateDefined()) {
            return;
        }

        $result['cert'] = $config->getCertificate();
    }

    /**
     * Adds the SSL file if exists.
     *
     * @param array  $result
     * @param Config $config
     * @return void
     */
    protected function addCaCertFileIfExists(array &$result, Config $config)
    {
        if (!$config->isCaCertDefined()) {
            return;
        }

        $result['verify'] = $config->getCaCert();
    }
}
