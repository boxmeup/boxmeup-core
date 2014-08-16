<?php

namespace Boxmeup\Test\Container;

use \Boxmeup\Container\Container;
use \Boxmeup\Container\ContainerItem;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreation()
    {
        $container = new Container([
            'name' => 'Test Container 1',
            'user' => 'UserReference', //@todo replace with user entity
        ]);
        $this->assertSame('Test Container 1', $container['name']);
        $this->assertSame('test-container-1', $container['slug']);
    }

    public function testSlugNotOverride()
    {
        $container = new Container([
            'name' => 'Test Container 1',
            'slug' => 'test-container-2'
        ]);
        $this->assertSame('Test Container 1', $container['name']);
        $this->assertSame('test-container-2', $container['slug']);
    }

    public function testItemCount()
    {
        $container = new Container([
            'name' => 'Test Container 1',
            'user' => 'UserReference', //@todo replace with user entity
        ]);
        $this->assertEquals(0, $container->getItemCount());
        $container->add(new ContainerItem([
            'body' => 'Test Item 1',
            'quantity' => 2
        ]));
        $this->assertEquals(2, $container->getItemCount());
    }
}
