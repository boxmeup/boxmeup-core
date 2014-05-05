<?php

namespace Boxmeup\Test\Domain;

use \Boxmeup\Domain\ReadAccessable;

class TestValueObject implements \ArrayAccess {
	use ReadAccessable;

	protected $data = [];

	public function __construct($value) {
		$this->data['value'] = $value;
	}

	public function __toString() {
		return $this->data['value'];
	}

}
