<?php


namespace App\Repository;


use Github\Domain\Model\UserInterface;
use Github\Domain\Repository\UserRepository as DomainUserRepository;

class UserRepository implements DomainUserRepository
{
    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function store(UserInterface $user): void
    {
        // TODO: Implement store() method.
    }

    /**
     * @param string $username
     * @param $password
     * @return UserInterface|null
     */
    public function findOneByUsernameAndPassword(string $username, $password): ?UserInterface
    {
        // TODO: Implement findOneByUsernameAndPassword() method.
    }

    /**
     * @param string $username
     * @return UserInterface|null
     */
    public function findOneByUsername(string $username): ?UserInterface
    {
        // TODO: Implement findOneByUsername() method.
    }

}