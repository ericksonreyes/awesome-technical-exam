<?php

namespace Github\Application;

use Github\Domain\Model\Exception\IncorrectPasswordException;
use Github\Domain\Model\Exception\UserNotFoundException;
use Github\Domain\Model\UserInterface;
use Github\Domain\Repository\UserRepository;

class UserAuthenticationHandler implements UserAuthenticationHandlerInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param AuthenticateUserCommandInterface $authenticateUserCommand
     */
    public function handleThis(AuthenticateUserCommandInterface $authenticateUserCommand): void
    {
        $username = $authenticateUserCommand->username();
        $password = $authenticateUserCommand->password();

        $anExistingUser = $this->userRepository->findOneByUsername($username);

        if ($anExistingUser instanceof UserInterface === false) {
            throw new UserNotFoundException();
        }

        if ($anExistingUser->password() !== $password) {
            throw new IncorrectPasswordException();
        }
    }

}
