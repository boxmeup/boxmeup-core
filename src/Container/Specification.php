<?php

namespace Boxmeup\Container;

use Boxmeup\User\User;
use Boxmeup\Value\Role;

class Specification
{

	protected $limits = [
		Role::TYPE_BASIC => [
			'containers' => 15,
			'items' => 60
		]
	];

	/**
	 * Get the number of containers a user is allowed to have.
	 *
	 * @param Boxmeup\User\User $user
	 * @return integer
	 */
	public function getLimit(User $user) {
		return $this->limits[(string)$user['role']]['containers'];
	}

	/**
	 * Get the number of items a user is allowed to have.
	 *
	 * @param Boxmeup\User\User $user
	 * @return integer
	 */
	public function getItemLimit(User $user) {
		return $this->limits[(string)$user['role']]['items'];
	}

	/**
	 * Statically create a specification instance.
	 *
	 * @return Boxmeup\Container\Specification
	 */
	public static function factory() {
		return new static();
	}
}
