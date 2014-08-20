<?php

namespace Boxmeup\Location;

use Boxmeup\User\User;
use Boxmeup\Value\Role;
use Boxmeup\Util\FactoryTrait;

class Specification
{
    use FactoryTrait;

    protected $limits = [
        Role::TYPE_BASIC => 5
    ];

    /**
     * Get the limit of locations a user is allowed to have.
     *
     * @param User $user
     * @return integer
     */
    public function getLimit(User $user)
    {
        return $this->limits[(string) $user['role']];
    }
}
