<?php

namespace Boxmeup\Value;

use Cjsaylor\Domain\ValueObject;

class Role extends ValueObject {

	const TYPE_BASIC = 0;

	protected $mapping = [
		self::TYPE_BASIC => 'basic'
	];

	public function __construct($value) {
		$this->data['value'] = $value;
	}

	public function __toString() {
		return $this->mapping[$this->data['value']];
	}

}
