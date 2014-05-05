<?php

namespace Boxmeup\Test\User;

use \Boxmeup\User\User;

class UserTest extends \PHPUnit_Framework_TestCase {

	public function testCreation() {
		$user = new User(['email' => 'test@test.com']);
		$this->assertInstanceOf('\Boxmeup\Value\Email', $user['email']);
		$this->assertEquals('test@test.com', $user['email']);
	}

}
