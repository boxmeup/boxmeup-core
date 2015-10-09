<?php

namespace Boxmeup\Repository;

use Doctrine\DBAL\Connection;
use Boxmeup\User\User;
use Boxmeup\Container\Container;
use Boxmeup\Container\ContainerItem;

class ContainerItemRepository
{
    const LIMIT_RECENT = 5;
    const LIMIT = 20;

    protected $db;

    protected $repos;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Retrieve the total number of containers
     *
     * @param User $user
     * @return integer
     */
    public function getTotalItemsByUser(User $user)
    {
        $stmt = $this->db->executeQuery(
            '
                select count(*) as total from container_items ci
                inner join containers c on c.id = ci.container_id
                where c.user_id = ?',
            [$user['id']],
            [\PDO::PARAM_INT]
        );

        return $stmt->fetch()['total'];
    }

    /**
     * Retrieve an generic container of recent items.
     *
     * @param User $user
     * @return Container
     */
    public function getRecentItemsByUser(User $user)
    {
        $parent = new Container(['name' => 'Recent']);
        $stmt = $this->db->executeQuery(
            '
                select ci.*, c.name as container_name, c.slug as container_slug from container_items ci
                inner join containers c on c.id = ci.container_id
                where c.user_id = ?
                order by ci.modified desc
                limit 0, ?
            ',
            [$user['id'], static::LIMIT_RECENT],
            [\PDO::PARAM_INT, \PDO::PARAM_INT]
        );
        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $item) {
            $item = new ContainerItem($item);
            $item['container'] = new Container([
                'id' => $item['container_id'],
                'slug' => $item['container_slug'],
                'name' => $item['container_name']
            ]);
            $parent->add($item);
        }

        return $parent;
    }

    /**
     * Adds container items to the container collection.
     *
     * Return the total number of items in this container (despite limit).
     *
     * @param Container $container
     * @param integer $limit Item limit to attach to container
     * @todo Implement limit
     * @return integer
     */
    public function getItemsByContainer(Container $container, $limit = -1)
    {
        $stmt = $this->db->executeQuery(
            '
                select ci.id, body, quantity, created, modified
                from container_items ci
                where ci.container_id = ?
            ',
            [$container['id']],
            [\PDO::PARAM_INT]
        );
        while ($row = $stmt->fetch()) {
            $item = new ContainerItem($row);
            $item->container = $container;
            $container->add($item);
        }

        // @todo replace with real limit
        return count($container);
    }
}
