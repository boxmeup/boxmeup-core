<?php

namespace Boxmeup\Test\Container;

use Boxmeup\User\User;
use Boxmeup\Container\Specification;

class SpecificationTest extends \PHPUnit_Framework_TestCase
{
	public function testLimit() {
		$user = new User(['email' => 'test@test.com']);
		$specification = new Specification();
		$this->assertEquals(10, $specification->getLimit($user));
	}

	public function testFactoryLimit() {
		$user = new User(['email' => 'test@test.com']);
		$this->assertEquals(10, Specification::factory()->getLimit($user));
	}
}
