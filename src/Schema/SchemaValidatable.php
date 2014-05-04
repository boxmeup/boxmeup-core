<?php

namespace Boxmeup\Schema;

interface SchemaValidatable {

	/**
	 * Array of keys required for this entity.
	 *
	 * @return array
	 */
	public function getRequiredSchema();

	/**
	 * Determines if this entity has the required fields for the schema.
	 *
	 * @return boolean
	 */
	public function verifyRequiredSchema();

}
