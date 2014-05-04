<?php

namespace Boxmeup\Domain;

abstract class Entity implements EntityInterface {
	use Accessable, Iteratable;

	/**
	 * Data container.
	 *
	 * @var array
	 */
	protected $data = [];

	public function __construct(array $initialData = []) {
		$this->data = $initialData;
	}

}
