<?php

namespace Boxmeup\Container;

use \Cjsaylor\Domain\CollectionEntity,
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
		parent::initialize($initialData);
		if (empty($this['slug'])) {
			$this['slug'] = $this->slugify('name');
		}
		$this->verifyRequiredSchema();
	}

	/**
	 * Add a ContainerItem to the Container collection.
	 *
	 * @param ContainerItem $item
	 * @return void
	 */
	public function add(ContainerItem $item) {
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
	 * @return string[]
	 */
	public function getRequiredSchema() {
		return [
			'user', 'name'
		];
	}

}
