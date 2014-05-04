<?php

namespace Boxmeup\Test\Domain;

class TestCollection extends \Boxmeup\Domain\Collection {

	public function add(TestEntity $entity) {
		$this->getItems()[] = $entity;
	}

}
