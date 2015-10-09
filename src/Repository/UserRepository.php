<?php

namespace Boxmeup\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Boxmeup\User\User;
use Boxmeup\Exception\NotFoundException;

class UserRepository
{
    /**
     * Database connection.
     *
     * @var Doctrine\DBAL\Connection
     */
    protected $db;

    /**
     * Constructor.
     *
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Retrieve a user by an ID.
     *
     * @param  string $id
     * @return User
     * @throws Boxmeup\Exception\NotFoundException
     */
    public function byId($id)
    {
        try {
            $qb = $this->db->createQueryBuilder();
            $qb->where('id = ' . $qb->createPositionalParameter($id));
            return $this->byEmailOrId($qb);
        } catch (NotFoundException $e) {
            throw new NotFoundException('User not found by provided ID.');
        }
    }

    /**
     * Retrieve a user by an email address.
     *
     * @param  string $email
     * @return User
     * @throws Boxmeup\Exception\NotFoundException
     */
    public function byEmail($email)
    {
        try {
            $qb = $this->db->createQueryBuilder();
            $qb->where('email = ' . $qb->createPositionalParameter($email));
            return $this->byEmailOrId($qb);
        } catch (NotFoundException $e) {
            throw new NotFoundException('User not found by provided email.');
        }
    }

    /**
     * Persist a user to storage.
     *
     * @param User $user
     * @return mixed
     */
    public function save(User $user)
    {
        return $this->{$user['id'] ? 'update' : 'create'}($user);
    }

    /**
     * Retrieve a user based on email or ID.
     *
     * @param \Doctrine\DBAL\Query\QueryBuilder $queryBuilder Should contain the where clause attached.
     * @return User
     * @throws Boxmeup\Exception\NotFoundException
     */
    private function byEmailOrId(QueryBuilder $queryBuilder)
    {
        $queryBuilder
            ->select('id', 'email', 'password', 'uuid', 'reset_password', 'created', 'modified')
            ->from('users');

        if (!$user = $queryBuilder->execute()->fetch()) {
            throw new NotFoundException('User not found by provided email or ID.');
        }

        return new User($user);
    }

    /**
     * Create a new user.
     *
     * @param User $user
     * @return mixed
     */
    protected function create(User $user)
    {
        throw new \DomainException('Not implemented yet.');
    }

    /**
     * Update a user.
     *
     * @param User $user
     * @return mixed
     */
    protected function update(User $user)
    {
        $qb = $this->db->createQueryBuilder();
        $qb
            ->update('users')
            ->where('id = :id')
            ->setParameter(':id', $user['id']);
        foreach ($user->getUpdatableFields() as $field) {
            $qb
                ->set($field, ':' . $field)
                ->setParameter(':' . $field, $user[$field]);
        }
        $qb->setParameter(':modified', date('Y-m-d H:i:s'));

        return $qb->execute();
    }
}
