<?php

namespace Boxmeup\User;

use \Boxmeup\Domain\Entity,
	\Boxmeup\Schema\SchemaValidatable,
	\Boxmeup\Schema\DefaultEntitySchemaValidate,
	\Boxmeup\Value\Email;

class User extends Entity implements SchemaValidatable {
	use DefaultEntitySchemaValidate {
		DefaultEntitySchemaValidate::verifyRequiredSchema as defaultVerifyRequiredSchema;
	}

	/**
	 * Initialization of container item entity.
	 *
	 * @param array $initialData
	 * @return void
	 * @throws Boxmeup\Exception\InvalidSchemaException
	 */
	public function initialize(array $initialData = []) {
		if (!empty($initialData['email']) && is_string($initialData['email'])) {
			$initialData['email'] = new Email($initialData['email']);
		}
		if (!array_key_exists('active', $initialData)) {
			$initialData['active'] = true;
		}
		parent::initialize($initialData);
		$this->verifyRequiredSchema();
	}

	/**
	 * Verify schema.
	 *
	 * @param array $data
	 * @return boolean
	 */
	public function verifyRequiredSchema(array $data = []) {
		$data = $data ?: $this->toArray();
		return $this->defaultVerifyRequiredSchema($data) && !$data['email'] instanceof Email;
	}

	/**
	 * Schema for containers items.
	 *
	 * @return array
	 */
	public function getRequiredSchema() {
		return [
			'email'
		];
	}

} 
