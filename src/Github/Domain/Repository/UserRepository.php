<?php


namespace Github\Domain\Repository;

use Github\Domain\Model\UserInterface;

/**
 * Interface UserRepository
 * @package Github\Domain\Repository
 */
interface UserRepository
{

    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function store(UserInterface $user): void;

    /**
     * @param string $username
     * @param $password
     * @return UserInterface|null
     */
    public function findOneByUsernameAndPassword(string $username, $password): ?UserInterface;

    /**
     * @param string $username
     * @return UserInterface|null
     */
    public function findOneByUsername(string $username): ?UserInterface;

}