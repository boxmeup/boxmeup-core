<?php

namespace Boxmeup\Test\User;

use \Boxmeup\User\User;

class UserTest extends \PHPUnit_Framework_TestCase {

	public function testCreation() {
		$user = new User(['email' => 'test@test.com']);
		$this->assertInstanceOf('\Boxmeup\Value\Email', $user['email']);
		$this->assertEquals('test@test.com', $user['email']);
	}

	public function testToArray() {
		$user = new User(['email' => 'test@test.com', 'id' => '1']);
		$result = $user->toArray();
		$this->assertEquals(['email' => 'test@test.com', 'id' => '1', 'active' => true], $result);
	}

	public function testEmailSetter() {
		$user = new User(['email' => 'test@test.com']);
		$user['email'] = 'test2@test.com';
		$this->assertInstanceOf('\Boxmeup\Value\Email', $user['email']);
		$this->assertEquals('test2@test.com', $user['email']);
	}

}
