<?php

namespace Boxmeup\Test\Container;

use Boxmeup\Container\Container;
use Boxmeup\Container\ContainerCollection;

class ContainerCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testAddAndGet()
    {
        $container = new Container(['id' => '1', 'name' => 'test container']);
        $collection = new ContainerCollection();
        $collection->add($container);
        $this->assertCount(1, $collection);
        $this->assertInstanceOf('\Boxmeup\Container\Container', $collection->get('1'));
    }

}
