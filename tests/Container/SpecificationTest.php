<?php

namespace Boxmeup\Test\Container;

use Boxmeup\User\User;
use Boxmeup\Container\Specification;

class SpecificationTest extends \PHPUnit_Framework_TestCase
{
	public function testLimit() {
		$user = new User(['email' => 'test@test.com']);
		$specification = new Specification();
		$this->assertEquals(15, $specification->getLimit($user));
	}

	public function testFactoryLimit() {
		$user = new User(['email' => 'test@test.com']);
		$this->assertEquals(15, Specification::factory()->getLimit($user));
	}

	public function testItemLimit() {
		$user = new User(['email' => 'test@test.com']);
		$this->assertEquals(60, Specification::factory()->getItemLimit($user));
	}
}
