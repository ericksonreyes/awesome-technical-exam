<?php

namespace Github\Application;

use Github\Domain\Model\Exception\IncorrectPasswordException;
use Github\Domain\Model\Exception\MissingEmailException;
use Github\Domain\Model\Exception\MissingPasswordException;
use Github\Domain\Model\Exception\UserNotFoundException;
use Github\Domain\Model\UserAttributesInterface;
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
        $email = trim($authenticateUserCommand->email());
        $password = trim($authenticateUserCommand->password());

        if ($email === '') {
            throw new MissingEmailException();
        }

        if ($password === '') {
            throw new MissingPasswordException();
        }

        $anExistingUser = $this->userRepository->findOneByEmail($email);
        if ($anExistingUser instanceof UserAttributesInterface === false) {
            throw new UserNotFoundException();
        }

        $encryptedPassword = $this->passwordEncryptionService->encrypt($password);
        if ($anExistingUser->password() !== $encryptedPassword) {
            throw new IncorrectPasswordException();
        }
    }

}
