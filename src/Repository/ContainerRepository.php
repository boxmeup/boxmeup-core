<?php

namespace Boxmeup\Repository;

use Doctrine\DBAL\Connection;
use Boxmeup\User\User;
use Boxmeup\Container\ContainerCollection;
use Boxmeup\Container\Container;
use Boxmeup\Container\Specification as ContainerSpecification;
use Boxmeup\Exception\NotFoundException;

class ContainerRepository
{
    const LIMIT = 20;

    const CONT_INCLUDE_ITEMS = 1;

    protected $db;

    protected $repos;

    protected $defaultListOptions = [
        'aggregate' => false
    ];

    public function __construct(Connection $db, array $repos = [])
    {
        $this->db = $db;
        $this->repos = $repos;
    }

    /**
	 * Get a paginated container collection.
	 *
	 * The results will contain data which will be an instance of Boxmeup\Container\ContainerCollection
	 * and total which is the total number of containers available.
	 *
	 * @param  User $user
	 * @param  integer $offset
	 * @return array
	 */
    public function getContainersByUser(User $user, $offset = 0)
    {
        $collection = new ContainerCollection();
        $stmt = $this->getListStatement();
        $stmt->bindValue(':user_id', $user['id'], \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', static::LIMIT, \PDO::PARAM_INT);
        $stmt->execute();

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $container) {
            $collection->add(new Container(array_merge($container, [
                'user' => $user
            ])));
        }

        return [
            'data' => $collection,
            'total' => $this->getTotalContainersByUser($user)
        ];
    }

    /**
	 * Get the total number of containers
	 *
	 * @param User $user
	 * @return integer
	 */
    public function getTotalContainersByUser(User $user)
    {
        $stmt = $this->getListStatement(['aggregate' => true]);
        $stmt->bindValue(':user_id', $user['id'], \PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetch()['total'];
    }

    /**
	 * Retrieve a container object based on slug.
	 *
	 * @param string $slug
	 * @return Container
	 * @todo Retrieve location objects
	 * @throws \LogicException If the user repository is not attached as a dependency
	 * @throws Boxmeup\Exception\NotFoundException
	 */
    public function getContainerBySlug($slug, $options = 0)
    {
        if (!isset($this->repos['user']) || !$this->repos['user'] instanceof UserRepository) {
            throw new \LogicException('User repository not located.');
        }
        if (
            $options & static::CONT_INCLUDE_ITEMS &&
            (
                !isset($this->repos['container_item']) ||
                !$this->repos['container_item'] instanceof ContainerItemRepository
            )
        ) {
            throw new \LogicException('Container item repository not located.');
        }
        $qb = $this->db->createQueryBuilder();
        $qb
            ->select('c.*')
            ->from('containers', 'c')
            ->where('slug = ' . $qb->createPositionalParameter($slug));
        $result = $qb->execute()->fetch();
        if (empty($result)) {
            throw new NotFoundException('Container not found.');
        }
        $container = new Container($qb->execute()->fetch());
        $container['user'] = $this->repos['user']->byId($container['user_id']);
        if ($options & static::CONT_INCLUDE_ITEMS) {
            $container['total_items'] = $this->repos['container_item']->getItemsByContainer($container);
        }

        return $container;
    }

    /**
	 * Save a container to persistent storage.
	 *
	 * @param Container $container
	 * @return void
	 */
    public function save(Container $container)
    {
        $this->{$container['id'] ? 'update' : 'create'}($container);
    }

    /**
	 * Remove a container and all it's items.
	 *
	 * @param Container $container
	 * @return void
	 */
    public function remove(Container $container)
    {
        $this->db->transactional(function ($db) use ($container) {
            $db->delete('container_items', ['container_id' => $container['id']]);
            $db->delete('containers', ['id' => $container['id']]);
        });
    }

    /**
	 * Create a container.
	 *
	 * @param Container $container
	 * @return void
	 * @throws DomainException If the user is unable to create any more containers.
	 */
    protected function create(Container $container)
    {
        if ($this->getTotalContainersByUser($container['user']) >= ContainerSpecification::factory()->getLimit($container['user'])) {
            throw new \DomainException('Container limit reached.');
        }
        $container['slug'] = $this->getUniqueSlug($container['slug']);
        $this->db->insert('containers', $container->schemaSerialize());
        $container['id'] = $this->db->lastInsertId();
    }

    /**
	 * Update a container.
	 *
	 * @param Container $container
	 * @return void
	 * @todo implement
	 */
    protected function update(Container $container)
    {
        throw new \DomainException('Not implemented.');
    }

    /**
	 * Get a unique slug value for provided slug.
	 *
	 * If the slug exists, it will return a new slug with a -\d with the maximum value of \d
	 * in existance.
	 *
	 * @param string $slug
	 * @return string
	 */
    protected function getUniqueSlug($slug)
    {
        $incrementPosition = strlen($slug) + 2; // Mysql starts at the position of the first letter.
        $exactWrap = sprintf('^%s$', $slug);
        $incrementWrap = sprintf('^%s-[0-9]+$', $slug);
        $stmt = $this->db->executeQuery(
            'select max(substring(slug from ?)) as increment from containers where slug regexp ? or slug regexp ?',
            [$incrementPosition, $exactWrap, $incrementWrap],
            [\PDO::PARAM_INT]
        );
        $result = $stmt->fetch()['increment'];
        if ($result === null) {
            return $slug;
        }

        return $slug . '-' . ($result + 1);
    }

    /**
	 * Prepares a statement for querying a list of containers.
	 *
	 * @return \Doctrine\DBAL\Statement
	 */
    protected function getListStatement(array $options = [])
    {
        $sql = 'select %s from containers where user_id = :user_id';
        $options = array_merge($this->defaultListOptions, $options);
        if (!$options['aggregate']) {
            return $this->db->prepare(sprintf($sql, '*') . ' limit :offset, :limit');
        }

        return $this->db->prepare(sprintf($sql, 'count(*) as total'));
    }
}
