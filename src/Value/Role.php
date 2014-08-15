<?php

namespace Boxmeup\Value;

use Cjsaylor\Domain\ValueObject;

class Role extends ValueObject
{
    const TYPE_BASIC = 'basic';

    public function __construct($value = self::TYPE_BASIC)
    {
        $this->data['value'] = $value;
    }

    public function __toString()
    {
        return $this->data['value'];
    }

}
