<?php

namespace Boxmeup\Domain;

trait Countable {

	/**
	 * Countable interface method
	 *
	 * @return integer
	 */
	public function count() {
		return count($this->getItems());
	}

}
