<?php

namespace Boxmeup\Test\Domain;

use \Boxmeup\Domain\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase {

	public function testIteratable() {
		$collection = new TestCollection();
		$collection->add(new TestEntity(['foo' => 'bar']));
		$collection->add(new TestEntity(['foo' => 'bar2']));
		$expector = $this->getMock('stdClass', ['test']);
		$expector->expects($this->exactly(2))->method('test');
		foreach ($collection as $entry) {
			$this->assertInstanceOf('Boxmeup\Test\Domain\TestEntity', $entry);
			$expector->test();
		}
	}

	public function testCountable() {
		$collection = new TestCollection();
		$collection->add(new TestEntity(['foo' => 'bar']));
		$collection->add(new TestEntity(['foo' => 'bar2']));
		$this->assertEquals(2, count($collection));
	}

	public function testEmpty() {
		$collection = new TestCollection();
		$this->assertTrue($collection->isEmpty());
		$collection->add(new TestEntity(['foo' => 'bar']));
		$this->assertFalse($collection->isEmpty());
	}

}
