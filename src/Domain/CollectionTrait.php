<?php

namespace Boxmeup\Domain;

trait CollectionTrait {

	/**
	 * Array representation.
	 *
	 * @return array
	 */
	public function toArray() {
		return $this->entries;
	}

	/**
	 * Determine if this collection is empty.
	 *
	 * @return boolean
	 */
	public function isEmpty() {
		return empty($this->entries);
	}

	/**
	 * Get a reference to the items array for this collection.
	 *
	 * @return array
	 */
	protected function &getItems() {
		return $this->entries;
	}

}
