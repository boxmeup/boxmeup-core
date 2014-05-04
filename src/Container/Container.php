<?php

namespace Boxmeup\Container;

use \Boxmeup\Domain\CollectionEntity,
	\Boxmeup\Schema\SchemaValidatable,
	\Boxmeup\Schema\DefaultEntitySchemaValidate,
	\Boxmeup\Util\SlugifyTrait;

class Container extends CollectionEntity implements SchemaValidatable {
	use DefaultEntitySchemaValidate, SlugifyTrait;

	/**
	 * Initialization of container collection entity.
	 *
	 * @param array $initialData
	 * @return void
	 * @todo implement user/location checks
	 * @throws Boxmeup\Exception\InvalidSchemaException
	 */
	public function initialize(array $initialData = []) {
		$this->verifyRequiredSchema(array_keys($initialData));
		parent::initialize($initialData);
		if (empty($this['slug'])) {
			$this['slug'] = $this->slugify('name');
		}
	}

	/**
	 * Add a ContainerItem to the Container collection.
	 *
	 * @param Boxmeup\Container\ContainerItem $item
	 * @return void
	 */
	public function add(ContainerItem $item) {
		$item['container'] = $this;
		$this->getItems()[] = $item;
	}

	/**
	 * Get total number of items in the container.
	 *
	 * @return integer
	 */
	public function getItemCount() {
		$total = 0;
		foreach ($this as $item) {
			$total += $item['quantity'];
		}
		return $total;
	}

	/**
	 * Schema for containers.
	 *
	 * @return array
	 */
	public function getRequiredSchema() {
		return [
			'user', 'name'
		];
	}

}