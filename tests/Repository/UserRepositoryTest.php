<?php

namespace Boxmeup\Test\Repository;

use Boxmeup\Test\Fixture\MainFixture;
use Boxmeup\Repository\UserRepository;

class UserRepositoryTest extends \Boxmeup\Test\DatabaseTestCase
{
	public function setUp() {
		$this->fixture = MainFixture::factory()->getRecords();
		$this->repo = new UserRepository(\Boxmeup\Test\getConnection());
		parent::setUp();
	}

	public function testById() {
		$result = $this->repo->byId(1);
		$this->assertInstanceOf('Boxmeup\User\User', $result);
	}

	/**
	 * @expectedException Boxmeup\Exception\NotFoundException
	 */
	public function testNotFoundById() {
		$this->repo->byId('nonexistant');
	}
}
