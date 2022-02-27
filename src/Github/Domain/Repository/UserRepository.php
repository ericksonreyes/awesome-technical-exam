<?php


namespace Github\Domain\Repository;

use Github\Domain\Model\UserAttributesInterface;
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
     * @param string $email
     * @param $password
     * @return UserInterface|null
     */
    public function findOneByEmailAndPassword(string $email, $password): ?UserAttributesInterface;

    /**
     * @param string $email
     * @return UserInterface|null
     */
    public function findOneByEmail(string $email): ?UserAttributesInterface;

}