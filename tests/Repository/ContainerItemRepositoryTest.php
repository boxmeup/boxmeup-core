<?php

namespace Boxmeup\Test\Repository;

use Boxmeup\Test\Fixture\MainFixture;
use Boxmeup\Repository\UserRepository;
use Boxmeup\Repository\ContainerItemRepository;
use Boxmeup\Container\Container;
use Boxmeup\Container\ContainerItem;

class ContainerItemRepositoryTest extends \Boxmeup\Test\DatabaseTestCase
{
    public function setUp()
    {
        $this->fixture = MainFixture::factory()->getRecords();
        $this->repo = new ContainerItemRepository(\Boxmeup\Test\getConnection());
        parent::setUp();
    }

    public function testGetItemsByContainer()
    {
        $container = new Container(['id' => 1, 'name' => 'Box 1']);
        $getResult = $this->repo->getItemsByContainer($container);
        $this->assertCount(2, $container);
        $this->assertEquals(2, $getResult);
        $result = $container->getIterator()->getArrayCopy();
        $this->assertInstanceOf('Boxmeup\Container\ContainerItem', $result[0]);
        $this->assertEquals(1, $result[0]['id']);
        $this->assertEquals(2, $result[1]['id']);
    }
}
