<?php

declare(strict_types=1);

namespace BankID\SDK\Annotations;

/**
 * Class TagName
 *
 * @package BankID\SDK\Annotations
 * @Annotation
 * @Target("PROPERTY")
 * @internal
 */
class Parameter
{

    /**
     * @Required
     * @var string The tag alias
     */
    public $alias;

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }
}
