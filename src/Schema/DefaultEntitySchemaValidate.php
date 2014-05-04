<?php

namespace Boxmeup\Schema;

use \Boxmeup\Schema\SchemaValidatable,
	\Boxmeup\Exception\InvalidSchemaException,
	\Boxmeup\Exception\InternalException;

trait DefaultEntitySchemaValidate {

	public function verifyRequiredSchema() {
		if (!$this instanceof SchemaValidatable) {
			throw new InternalException('Must implement SchemaValidatable interface.');
		}
		$diff = array_intersect(array_keys($this->toArray()), $this->getRequiredSchema());
		return empty($diff);
	}

}
