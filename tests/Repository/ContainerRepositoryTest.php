<?php

namespace Boxmeup\Test\Repository;

use Boxmeup\Test\Fixture\MainFixture;
use Boxmeup\Repository\UserRepository;
use Boxmeup\Repository\ContainerRepository;
use Boxmeup\Container\Container;
use Boxmeup\Container\Specification as ContainerSpecification;

class ContainerRepositoryTest extends \Boxmeup\Test\DatabaseTestCase
{
    public function setUp()
    {
        $this->fixture = MainFixture::factory()->getRecords();
        $this->user = new UserRepository(\Boxmeup\Test\getConnection());
        $this->repo = new ContainerRepository(\Boxmeup\Test\getConnection(), [
            'user' => $this->user
        ]);
        parent::setUp();
    }

    public function testGetTotalContainersByUser()
    {
        $result = $this->repo->getTotalContainersByUser($this->user->byId(1));
        $this->assertEquals(1, $result);
    }

    public function testCreate()
    {
        $container = new Container([
            'user' => $this->user->byId(1),
            'name' => 'Test Create',
        ]);
        $this->repo->save($container);
        $this->assertNotEmpty($container['id']);
    }

    public function testUniqueSlugCreation()
    {
        $container = new Container([
            'user' => $this->user->byId(1),
            'name' => 'Test Create',
        ]);
        $this->repo->save($container);
        $this->assertNotEmpty($container['id']);
        $this->assertEquals('test-create', $container['slug']);

        // Test repeated slug
        unset($container['id']);
        $container['slug'] = 'test-create';
        $this->repo->save($container);
        $this->assertNotEmpty($container['id']);
        $this->assertEquals('test-create-1', $container['slug']);

        // Test edge case
        unset($container['id']);
        $container['slug'] = 'test-create-1';
        $this->repo->save($container);
        $this->assertNotEmpty($container['id']);
        $this->assertEquals('test-create-1-1', $container['slug']);
    }

    /**
	 * @expectedException \DomainException
	 */
    public function testCreateLimit()
    {
        $container = new Container([
            'user' => $this->user->byId(1),
            'name' => 'Test Maximum'
        ]);
        $limit = ContainerSpecification::factory()->getLimit($container['user']);
        while ($limit >= 0) {
            $this->repo->save($container);
            unset($container['id']);
            $limit--;
        }
    }

    /**
	 * @expectedException DomainException
	 */
    public function testUpdate()
    {
        $container = new Container(['id' => 1, 'name' => 'Test Update']);
        $this->repo->save($container);
    }

    public function testGetBySlug()
    {
        $container = $this->repo->getContainerBySlug('box-1');
        $this->assertInstanceOf('Boxmeup\Container\Container', $container);
        $this->assertEquals('box-1', $container['slug']);
        $this->assertInstanceOf('Boxmeup\User\User', $container['user']);
        $this->assertEquals(1, $container['user']['id']);
    }

    /**
	 * @todo Add tests covering the removal of items as well.
	 */
    public function testDelete()
    {
        $container = $this->repo->getContainerBySlug('box-1');
        $this->assertInstanceOf('Boxmeup\Container\Container', $container);
        $this->repo->remove($container);
        $this->setExpectedException('Boxmeup\Exception\NotFoundException');
        $container = $this->repo->getContainerBySlug('box-1');
    }

}
