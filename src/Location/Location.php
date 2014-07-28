<?php

namespace Boxmeup\Location;

use \Cjsaylor\Domain\Entity,
	\Boxmeup\Schema\SchemaValidatable,
	\Boxmeup\Schema\DefaultEntitySchemaValidate;

class Location extends Entity implements SchemaValidatable
{
	use DefaultEntitySchemaValidate;

	/**
	 * Schema for containers items.
	 *
	 * @return array
	 */
	public function getRequiredSchema() {
		return [
			'name'
		];
	}
}
