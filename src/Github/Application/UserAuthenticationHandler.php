<?php

namespace Github\Application;

use Exception;
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

    /**
     * @var UserAuthenticationHandlerInterface[]
     */
    private $successfulAuthenticationHandlers = [];

    /**
     * @var FailedUserAuthenticationAttemptHandlerInterface[]
     */
    private $failedUserAuthenticationAttemptHandlers = [];

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

        try {
            $anExistingUser = $this->userRepository->findOneByUsername($username);

            if ($anExistingUser instanceof UserInterface === false) {
                throw new UserNotFoundException();
            }

            if ($anExistingUser->password() !== $password) {
                throw new IncorrectPasswordException();
            }

            foreach ($this->successfulAuthenticationHandlers as $successfulAuthenticationHandler) {
                $successfulAuthenticationHandler->handleThis($authenticateUserCommand);
            }
        } catch (Exception $exception) {
            foreach ($this->failedUserAuthenticationAttemptHandlers as $failedUserAuthenticationAttemptHandler) {
                $failedUserAuthenticationAttemptHandler->handleThis(
                    $authenticateUserCommand,
                    $exception
                );
            }
            throw new $exception;
        }
    }

}
