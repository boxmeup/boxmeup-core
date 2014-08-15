<?php

namespace Boxmeup\Util;

trait FactoryTrait
{
    /**
	 * Factory method for statically intantiating a class.
	 *
	 * @return mixed
	 */
    public static function factory()
    {
        return new static();
    }
}
