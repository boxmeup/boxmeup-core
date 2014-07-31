<?php

namespace Boxmeup\Schema;

interface SchemaSerializable
{
	/**
	 * Returns a key-value array of column to column value
	 *
	 * @return array
	 */
	public function schemaSerialize();
}
