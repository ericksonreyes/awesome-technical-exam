<?php

namespace Github\Application;

use Github\Domain\Model\Exception\IncorrectPasswordException;
use Github\Domain\Model\Exception\MissingPasswordException;
use Github\Domain\Model\Exception\MissingUsernameException;
use Github\Domain\Model\Exception\UserNotFoundException;
use Github\Domain\Model\UserInterface;
use Github\Domain\Repository\UserRepository;

/**
 * Class UserAuthenticationHandler
 * @package Github\Application
 */
class UserAuthenticationHandler extends UserAuthenticationAwareHandler implements UserAuthenticationHandlerInterface
{

    /**
     * UserAuthenticationHandler constructor.
     * @param UserRepository $userRepository
     * @param UserPasswordEncryptionServiceInterface $passwordEncryptionService
     */
    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncryptionServiceInterface $passwordEncryptionService
    )
    {
        parent::__construct($userRepository, $passwordEncryptionService);
    }

    /**
     * @param AuthenticateUserCommandInterface $authenticateUserCommand
     */
    public function handleThis(AuthenticateUserCommandInterface $authenticateUserCommand): void
    {
        $username = trim($authenticateUserCommand->username());
        $password = trim($authenticateUserCommand->password());

        if ($username === '') {
            throw new MissingUsernameException();
        }

        if ($password === '') {
            throw new MissingPasswordException();
        }

        $anExistingUser = $this->userRepository->findOneByEmail($username);
        if ($anExistingUser instanceof UserInterface === false) {
            throw new UserNotFoundException();
        }

        $encryptedPassword = $this->passwordEncryptionService->encrypt($password);
        if ($anExistingUser->password() !== $encryptedPassword) {
            throw new IncorrectPasswordException();
        }
    }

}
