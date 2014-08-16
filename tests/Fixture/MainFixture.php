<?php

namespace Boxmeup\Test\Fixture;

use Boxmeup\Util\FactoryTrait;
use Boxmeup\Test\FixtureInterface;

class MainFixture implements FixtureInterface
{
    use FactoryTrait;

    public function getRecords()
    {
        return [
            'users' => [
                [
                    'id' => 1,
                    'email' => 'test@test.com',
                    'password' => 'somehash',
                    'uuid' => 'deprecated',
                    'created' => '2014-01-01 00:00:00',
                    'modified' => '2014-01-01 00:00:00'
                ]
            ],
            'containers' => [
                [
                    'id' => 1,
                    'user_id' => 1,
                    'uuid' => 'deprecated',
                    'name' => 'Box 1',
                    'slug' => 'box-1',
                    'container_item_count' => 1,
                    'created' => '2014-01-01 00:00:00',
                    'modified' => '2014-01-01 00:00:00'
                ]
            ],
            'container_items' => [
                [
                    'id' => 1,
                    'container_id' => 1,
                    'body' => 'item 1',
                    'quantity' => 1,
                    'created' => '2014-01-01 00:00:00',
                    'modified' => '2014-01-01 00:00:00'
                ],
                [
                    'id' => 2,
                    'container_id' => 1,
                    'body' => 'item 2',
                    'quantity' => 2,
                    'created' => '2014-01-01 00:00:00',
                    'modified' => '2014-01-01 00:00:00'
                ]
            ]
        ];
    }
}
