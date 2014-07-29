<?php

namespace Boxmeup\Test\Repository;

use Boxmeup\Test\Fixture\MainFixture;
use Boxmeup\Repository\UserRepository;
use Boxmeup\Repository\ContainerRepository;

class ContainerRepositoryTest extends \Boxmeup\Test\DatabaseTestCase
{
	public function setUp() {
		$this->fixture = MainFixture::factory()->getRecords();
		$this->repo = new ContainerRepository(\Boxmeup\Test\getConnection());
		$this->user = new UserRepository(\Boxmeup\Test\getConnection());
		parent::setUp();
	}

	public function testGetTotalContainersByUser() {
		$result = $this->repo->getTotalContainersByUser($this->user->byId(1));
		$this->assertEquals(1, $result);
	}
}
