<?php

namespace Boxmeup\Repository;

use Doctrine\DBAL\Connection;
use Boxmeup\User\User;

class LocationRepository
{
	protected $db;

	protected $repos;

	public function __construct(Connection $db) {
		$this->db = $db;
	}

	/**
	 * Retrieve the total number of locations a user currently has.
	 *
	 * @param Boxmeup\User\User $user
	 * @return integer
	 */
	public function getTotalLocationsByUser(User $user) {
		return (int)$this->db->executeQuery(
			'select count(*) as total from locations where user_id = ?',
			[$user['id']],
			[\PDO::PARAM_INT]
		)->fetch()['total'];
	}

}
