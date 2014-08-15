<?php

namespace Boxmeup\Container;

use Boxmeup\User\User;
use Boxmeup\Value\Role;
use Boxmeup\Util\FactoryTrait;

class Specification
{
    use FactoryTrait;

    protected $limits = [
        Role::TYPE_BASIC => [
            'containers' => 15,
            'items' => 60
        ]
    ];

    /**
	 * Get the number of containers a user is allowed to have.
	 *
	 * @param User $user
	 * @return integer
	 */
    public function getLimit(User $user)
    {
        return $this->limits[(string) $user['role']]['containers'];
    }

    /**
	 * Get the number of items a user is allowed to have.
	 *
	 * @param User $user
	 * @return integer
	 */
    public function getItemLimit(User $user)
    {
        return $this->limits[(string) $user['role']]['items'];
    }
}
