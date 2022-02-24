<?php

namespace Github\Application;

use Github\Domain\Model\Exception\InvalidEmailException;

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
        $email = $registerUserCommand->username();
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidEmailException('Incorrect e-mail address format.');
        }

        $this->userRegistrationHandler->handleThis($registerUserCommand);
    }


}
