<?php

namespace Boxmeup\Container;

use \Cjsaylor\Domain\Entity,
	\Boxmeup\Schema\SchemaValidatable,
	\Boxmeup\Schema\DefaultEntitySchemaValidate;

class ContainerItem extends Entity implements SchemaValidatable {
	use DefaultEntitySchemaValidate;

	/**
	 * Initialization of container item entity.
	 *
	 * @param array $initialData
	 * @return void
	 * @throws Boxmeup\Exception\InvalidSchemaException
	 */
	public function initialize(array $initialData = []) {
		if (!array_key_exists('quantity', $initialData)) {
			$initialData['quantity'] = 1;
		}
		$initialData['quantity'] = abs($initialData['quantity']);
		parent::initialize($initialData);
		$this->verifyRequiredSchema();
	}

	/**
	 * Schema for containers items.
	 *
	 * @return array
	 */
	public function getRequiredSchema() {
		return [
			'body', 'quantity'
		];
	}

}
