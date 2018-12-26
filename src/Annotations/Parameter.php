<?php

namespace BankID\SDK\Annotations;

/**
 * Class TagName
 *
 * @package MB\Agresso\XML\Example\Annotations
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
