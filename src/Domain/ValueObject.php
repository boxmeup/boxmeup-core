<?php

namespace Boxmeup\Domain;

abstract class ValueObject implements ValueObjectInterface {
	use ReadAccessable;

	/**
	 * Value object data store.
	 *
	 * @var array
	 */
	protected $data = [];
}
