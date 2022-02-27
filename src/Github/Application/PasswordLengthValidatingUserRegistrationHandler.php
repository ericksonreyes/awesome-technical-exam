<?php

namespace Github\Application;

use Github\Domain\Model\Exception\PasswordTooShortException;

/**
 * Class PasswordLengthValidatingUserRegistrationHandler
 * @package Github\Application
 */
class PasswordLengthValidatingUserRegistrationHandler implements UserRegistrationHandlerInterface
{
    /**
     * @var UserRegistrationHandlerInterface
     */
    private $userRegistrationHandler;

    /**
     * @var int
     */
    private $requiredMinimumPasswordLength;

    /**
     * PasswordLengthValidatingUserRegistrationHandler constructor.
     * @param UserRegistrationHandlerInterface $userRegistrationHandler
     * @param int $requiredMinimumPasswordLength
     */
    public function __construct(
        UserRegistrationHandlerInterface $userRegistrationHandler,
        int $requiredMinimumPasswordLength
    )
    {
        $this->userRegistrationHandler = $userRegistrationHandler;
        $this->requiredMinimumPasswordLength = $requiredMinimumPasswordLength;
    }

    /**
     * @param RegisterUserCommandInterface $registerUserCommand
     */
    public function handleThis(RegisterUserCommandInterface $registerUserCommand): void
    {
        $password = trim($registerUserCommand->password());
        if (strlen($password) < $this->requiredMinimumPasswordLength) {
            throw new PasswordTooShortException(
                'Password must be at least ' . $this->requiredMinimumPasswordLength . ' characters long.'
            );
        }

        $this->userRegistrationHandler->handleThis($registerUserCommand);
    }


}
