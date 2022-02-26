<?php

namespace Github\Application;

use Github\Domain\Model\Exception\IncorrectPasswordException;
use Github\Domain\Model\Exception\UserNotFoundException;
use Github\Domain\Model\UserInterface;
use Github\Domain\Repository\UserRepository;

class UserAuthenticationHandler extends UserAuthenticationAwareHandler implements UserAuthenticationHandlerInterface
{
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

        $encryptedPassword = $this->passwordEncryptionService->encrypt($password);
        if ($anExistingUser->password() !== $encryptedPassword) {
            throw new IncorrectPasswordException();
        }
    }

}
