<?php

namespace Boxmeup\Test\User;

use \Boxmeup\User\User;

class UserTest extends \PHPUnit_Framework_TestCase {

	public function testCreation() {
		$user = $this->generateUser();
		$this->assertInstanceOf('\Boxmeup\Value\Email', $user['email']);
		$this->assertEquals('test@test.com', $user['email']);
	}

	public function testToArray() {
		$user = $this->generateUser();
		$result = $user->toArray();
		$this->assertEquals(
			[
				'id' => 1,
				'email' => 'test@test.com',
				'role' => 'basic',
				'password' => 'somehash',
				'is_active' => true,
				'reset_password' => false,
				'created' => '2014-01-01 00:00:00',
				'modified' => '2014-01-01 00:00:00'
			],
			$result
		);
	}

	public function testEmailSetter() {
		$user = $this->generateUser();
		$user['email'] = 'test2@test.com';
		$this->assertInstanceOf('\Boxmeup\Value\Email', $user['email']);
		$this->assertEquals('test2@test.com', $user['email']);
	}

	public function testUpdatbleFields() {
		$user = $this->generateUser();
		$this->assertEquals(['email', 'password', 'modified'], $user->getUpdatableFields());
	}

	protected function generateUser() {
		return new User([
			'id' => 1,
			'email' => 'test@test.com',
			'password' => 'somehash',
			'is_active' => true,
			'reset_password' => false,
			'created' => '2014-01-01 00:00:00',
			'modified' => '2014-01-01 00:00:00'
		]);
	}

}
