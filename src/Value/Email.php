<?php

namespace Boxmeup\Value;

use Boxmeup\Exception\InvalidParameterException;

class Email {

	/**
	 * Email Address.
	 *
	 * @var string
	 */
	protected $address;

	/**
	 * Constructor.
	 *
	 * @param string $address
	 * @todo Validate email address
	 * @throws Boxmeup\Exception\InvalidParameterException
	 */
	public function __construct($address) {
		$this->address = $address;
	}

	/**
	 * Email address.
	 * 
	 * @return string
	 */
	public function __toString() {
		return $this->address;
	}

}
