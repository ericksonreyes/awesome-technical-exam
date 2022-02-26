<?php


namespace Acceptance\Mock;


use Github\Domain\Model\User;
use Github\Domain\Model\UserAttributesInterface;
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
     * MockUserRepository constructor.
     */
    public function __construct()
    {
        $user = new User('user-0001');
        $user->signUp('active-user@reyes.com', 'encrypted-SecuredPassword');

        $this->users['user-1001'] = $user;
    }

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
    public function findOneByUsernameAndPassword(string $username, $password): ?UserAttributesInterface
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
    public function findOneByUsername(string $username): ?UserAttributesInterface
    {
        foreach ($this->users as $user) {
            if ($user->username() === $username) {
                return $user;
            }
        }
        return null;
    }


}