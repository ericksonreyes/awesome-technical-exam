<?php


namespace Acceptance\Mock;


use Github\Domain\Model\UserInterface;
use Github\Domain\Repository\UserRepository;

/**
 * Class MockUserRepository
 * @package Acceptance\Mock
 */
class MockUserRepository implements UserRepository
{
    /**
     * @var UserInterface[]
     */
    private $users = [];

    /**
     * @param UserInterface $user
     */
    public function store(UserInterface $user): void
    {
        $this->users[$user->id()] = $user;
    }

    /**
     * @param string $username
     * @param $password
     * @return UserInterface|null
     */
    public function findOneByUsernameAndPassword(string $username, $password): ?UserInterface
    {
        foreach ($this->users as $user) {
            if ($user->username() === $username && $user->password() === $password) {
                return $user;
            }
        }
        return null;
    }

    /**
     * @param string $username
     * @return UserInterface|null
     */
    public function findOneByUsername(string $username): ?UserInterface
    {
        foreach ($this->users as $user) {
            if ($user->username() === $username) {
                return $user;
            }
        }
        return null;
    }


}