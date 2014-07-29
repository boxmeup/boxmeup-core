<?php

namespace Boxmeup\Repository;

use Doctrine\DBAL\Connection;
use Boxmeup\User\User;
use Boxmeup\Container\ContainerCollection;
use Boxmeup\Container\Container;

class ContainerRepository
{
	const LIMIT = 20;

	protected $db;

	protected $repos;

	protected $defaultListOptions = [
		'aggregate' => false
	];

	public function __construct(Connection $db) {
		$this->db = $db;
	}

	/**
	 * Get a paginated container collection.
	 *
	 * The results will contain data which will be an instance of Boxmeup\Container\ContainerCollection
	 * and total which is the total number of containers available.
	 *
	 * @param  Boxmeup\User\User $user
	 * @param  integer $offset
	 * @return array
	 */
	public function getContainersByUser(User $user, $offset = 0) {
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
	 * @param Boxmeup\User\User $user
	 * @return integer
	 */
	public function getTotalContainersByUser(User $user) {
		$stmt = $this->getListStatement(['aggregate' => true]);
		$stmt->bindValue(':user_id', $user['id'], \PDO::PARAM_INT);
		$stmt->execute();

		return (int)$stmt->fetch()['total'];
	}

	/**
	 * Prepares a statement for querying a list of containers.
	 *
	 * @param boolean $aggregate Should return the aggregate results
	 * @return Doctrine\DBAL\Statement
	 */
	protected function getListStatement(array $options = []) {
		$sql = 'select %s from containers where user_id = :user_id';
		$options = array_merge($this->defaultListOptions, $options);
		if (!$options['aggregate']) {
			return $this->db->prepare(sprintf($sql, '*') . ' limit :offset, :limit');
		}

		return $this->db->prepare(sprintf($sql, 'count(*) as total'));
	} 

}
