<?php

namespace Boxmeup\Value;

use \Cjsaylor\Domain\ReadAccessable;

class Address implement \ArrayAccess
{
    use ReadAccessable, DefaultEntitySchemaValidate;

    /**
	 * Address.
	 *
	 * @var array
	 */
    protected $data = [];

    /**
	 * Constructor.
	 *
	 * @param string $address
	 * @todo Add proper attributes and validation.
	 */
    public function __construct($address)
    {
        $this->data['address'] = $address;
    }

    /**
	 * String representation.
	 *
	 * @return string
	 */
    public function __toString()
    {
        return $this->data['address'];
    }

}
