<?php

namespace Boxmeup\Test\Domain;

use \Boxmeup\Domain\ValueObject;

class TestValueObject extends ValueObject {

	public function __construct($value) {
		$this->data['value'] = $value;
	}

	public function __toString() {
		return $this->data['value'];
	}

}
