<?php

namespace Boxmeup\Test\Location;

use Boxmeup\Location\Specification as LocationSpecification;
use Boxmeup\User\User;

class SpecificationTest extends \PHPUnit_Framework_TestCase
{
	public function testLimitSpecification() {
		$user = new User(['email' => 'test@test.com']);
		$this->assertEquals(5, LocationSpecification::factory()->getLimit($user));
	}
}
