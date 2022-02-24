<?php

namespace Github\Application;

use Github\Domain\Model\User;
use Github\Domain\Repository\UserRepository;

/**
 * Class UserRegistrationHandler
 * @package Github\Application
 */
class UserRegistrationHandler implements UserRegistrationHandlerInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserRegistrationHandler constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param RegisterUserCommandInterface $registerUserCommand
     */
    public function handleThis(RegisterUserCommandInterface $registerUserCommand): void
    {
        $newUser = new User();
        $this->userRepository->store($newUser);
    }
}
