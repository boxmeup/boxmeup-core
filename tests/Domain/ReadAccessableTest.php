<?php

namespace Boxmeup\Test\Domain;

class ReadAccessableTest extends \PHPUnit_Framework_TestCase {

	public function testAccess() {
		$value = new TestValueObject('a');
		$this->assertSame('a', $value['value']);
		$this->assertSame('a', (string)$value);
	}

	/**
	 * @expectedException \LogicException
	 */
	public function testInvalidAccess() {
		$value = new TestValueObject('a');
		$value['value'] = 'b';
	}

}
