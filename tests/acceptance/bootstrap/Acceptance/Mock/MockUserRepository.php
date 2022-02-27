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
     * @param string $email
     * @param $password
     * @return UserInterface|null
     */
    public function findOneByEmailAndPassword(string $email, $password): ?UserAttributesInterface
    {
        foreach ($this->users as $user) {
            if ($user->email() === $email && $user->password() === $password) {
                return $user;
            }
        }
        return null;
    }

    /**
     * @param string $email
     * @return UserInterface|null
     */
    public function findOneByEmail(string $email): ?UserAttributesInterface
    {
        foreach ($this->users as $user) {
            if ($user->email() === $email) {
                return $user;
            }
        }
        return null;
    }


}