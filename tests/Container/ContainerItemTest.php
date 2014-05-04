<?php

namespace Boxmeup\Test\Container;

use \Boxmeup\Container\ContainerItem;

class ContainerItemTest extends \PHPUnit_Framework_TestCase {

	public function testCreation() {
		$item = new ContainerItem([
			'container' => 'ContainerReference', // @todo This should be a container entity
			'body' => 'Some container item'
		]);
		$this->assertSame('Some container item', $item['body']);
		$this->assertSame(1, $item['quantity']);
	}

}
