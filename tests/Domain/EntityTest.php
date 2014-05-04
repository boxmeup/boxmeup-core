<?php

namespace Boxmeup\Test\Domain;

class EntityTest extends \PHPUnit_Framework_TestCase {

	public function testEntityAccessable() {
		$entity = new TestEntity(['entry1' => 1, 'entry2' => true]);
		$this->assertSame(1, $entity['entry1']);
		$this->assertTrue($entity['entry2']);
	}

}

