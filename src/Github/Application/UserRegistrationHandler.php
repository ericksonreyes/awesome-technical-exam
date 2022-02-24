<?php

namespace Github\Application;

use Github\Domain\Model\Exception\MismatchedPasswordsException;
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
        $id = trim($registerUserCommand->id());
        $username = trim($registerUserCommand->username());
        $password = trim($registerUserCommand->password());
        $passwordConfirmation = trim($registerUserCommand->passwordConfirmation());

        if ($password !== $passwordConfirmation) {
            throw new MismatchedPasswordsException();
        }

        $newUser = new User($id);
        $newUser->signUp($username, $password);
        $this->userRepository->store($newUser);
    }
}
