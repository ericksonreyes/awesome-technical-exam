<?php

namespace Github\Application;

use Github\Domain\Model\Exception\InvalidEmailException;
use Github\Domain\Model\Exception\MissingEmailException;

/**
 * Class EmailFormatValidatingUserRegistrationHandler
 * @package Github\Application
 */
class EmailFormatValidatingUserRegistrationHandler implements UserRegistrationHandlerInterface
{
    /**
     * @var UserRegistrationHandlerInterface
     */
    private $userRegistrationHandler;

    /**
     * EmailFormatValidatingUserRegistrationHandler constructor.
     * @param UserRegistrationHandlerInterface $userRegistrationHandler
     */
    public function __construct(UserRegistrationHandlerInterface $userRegistrationHandler)
    {
        $this->userRegistrationHandler = $userRegistrationHandler;
    }

    /**
     * @param RegisterUserCommandInterface $registerUserCommand
     */
    public function handleThis(RegisterUserCommandInterface $registerUserCommand): void
    {
        $email = trim($registerUserCommand->email());

        if (trim($email) === '') {
            throw new MissingEmailException();
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidEmailException('Incorrect e-mail address format.');
        }

        $this->userRegistrationHandler->handleThis($registerUserCommand);
    }


}
