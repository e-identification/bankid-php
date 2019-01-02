<?php

namespace BankID\SDK;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

const ENVIRONMENT_TEST = 'test';
const ENVIRONMENT_PRODUCTION = 'production';

/**
 * Returns the full path to the ca file.
 *
 * @param string $environment
 * @return string
 * @throws InvalidArgumentException
 * @phan-suppress PhanTypeMismatchReturn
 */
function ca_file(string $environment): string
{
    Assert::oneOf($environment, [ENVIRONMENT_TEST, ENVIRONMENT_PRODUCTION]);

    $path = null;

    switch ($environment) {
        case ENVIRONMENT_TEST:
            $path = __DIR__ . '/../rsc/certificates/ca.test.crt';
            break;
        case ENVIRONMENT_PRODUCTION:
            $path = __DIR__ . '/../rsc/certificates/ca.production.crt';

            break;
    }

    return $path;
}

namespace BankID\SDK\Responses;

const ERROR_CODE_ALREADY_IN_PROGRESS = 'alreadyInProgress';
const ERROR_CODE_INVALID_PARAMETERS = 'invalidParameters';
const ERROR_CODE_UNAUTHORIZED = 'unauthorized';
const ERROR_CODE_NOT_FOUND = 'notFound';
const ERROR_CODE_REQUEST_TIMEOUT = 'requestTimeout';
const ERROR_CODE_UNSUPPORTED_MEDIA_TYPE = 'unsupportedMediaType';
const ERROR_CODE_INTERNAL_ERROR = 'internalError';
const ERROR_CODE_MAINTENANCE = 'Maintenance';
