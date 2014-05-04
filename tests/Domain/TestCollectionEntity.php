<?php

namespace Boxmeup\Test\Domain;

class TestCollectionEntity extends \Boxmeup\Domain\CollectionEntity {

	public function add(TestEntity $entity) {
		$this->getItems()[] = $entity;
	}

}
