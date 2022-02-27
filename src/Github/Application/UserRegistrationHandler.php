<?php

namespace Github\Application;

use Github\Domain\Model\Exception\EmailAlreadyUsedException;
use Github\Domain\Model\Exception\MismatchedPasswordsException;
use Github\Domain\Model\Exception\MissingEmailException;
use Github\Domain\Model\Exception\MissingPasswordException;
use Github\Domain\Model\Exception\MissingUsernameException;
use Github\Domain\Model\User;
use Github\Domain\Model\UserAttributesInterface;
use Github\Domain\Model\UserInterface;
use Github\Domain\Repository\UserRepository;

/**
 * Class UserRegistrationHandler
 * @package Github\Application
 */
class UserRegistrationHandler extends UserAuthenticationAwareHandler implements UserRegistrationHandlerInterface
{
    /**
     * UserRegistrationHandler constructor.
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
     * @param RegisterUserCommandInterface $registerUserCommand
     */
    public function handleThis(RegisterUserCommandInterface $registerUserCommand): void
    {
        $id = trim($registerUserCommand->id());
        $email = trim($registerUserCommand->email());
        $password = trim($registerUserCommand->password());
        $passwordConfirmation = trim($registerUserCommand->passwordConfirmation());

        if ($email === '') {
            throw new MissingEmailException();
        }

        if ($password === '') {
            throw new MissingPasswordException();
        }

        if ($password !== $passwordConfirmation) {
            throw new MismatchedPasswordsException('Passwords does not match.');
        }

        if ($this->emailIsAlreadyUsed($email)) {
            throw new EmailAlreadyUsedException('Username is already registered.');
        }

        $encryptedPassword = $this->passwordEncryptionService->encrypt($password);
        $newUser = new User($id);
        $newUser->signUp($email, $encryptedPassword);
        $this->userRepository->store($newUser);
    }

    /**
     * @param string $email
     * @return bool
     */
    protected function emailIsAlreadyUsed(string $email): bool
    {
        return $this->userRepository->findOneByEmail($email) instanceof UserInterface ||
            $this->userRepository->findOneByEmail($email) instanceof UserAttributesInterface;
    }
}
