<?php

namespace Boxmeup\Util;

trait FactoryTrait
{
    /**
     * Factory method for statically intantiating a class.
     *
     * @return FactoryTrait
     */
    public static function factory()
    {
        return new static();
    }
}
