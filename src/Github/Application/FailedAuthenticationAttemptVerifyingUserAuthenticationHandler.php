<?php

namespace Github\Application;

use Exception;
use Github\Domain\Model\Exception\IncorrectPasswordException;
use Github\Domain\Model\Exception\TooManyFailedAuthenticationAttemptsException;

/**
 * Class FailedAuthenticationAttemptVerifyingUserAuthenticationHandler
 * @package Github\Application
 */
class FailedAuthenticationAttemptVerifyingUserAuthenticationHandler implements UserAuthenticationHandlerInterface
{
    /**
     * @var UserAuthenticationHandlerInterface
     */
    private $userAuthenticationHandler;

    /**
     * @var FailedUserAuthenticationAttemptLoggerInterface
     */
    private $failedAttemptLogger;

    /**
     * FailedAuthenticationAttemptVerifyingUserAuthenticationHandler constructor.
     * @param UserAuthenticationHandlerInterface $userAuthenticationHandler
     * @param FailedUserAuthenticationAttemptLoggerInterface $failedAttemptLogger
     */
    public function __construct(
        UserAuthenticationHandlerInterface $userAuthenticationHandler,
        FailedUserAuthenticationAttemptLoggerInterface $failedAttemptLogger
    )
    {
        $this->userAuthenticationHandler = $userAuthenticationHandler;
        $this->failedAttemptLogger = $failedAttemptLogger;
    }


    /**
     * @param AuthenticateUserCommandInterface $authenticateUserCommand
     */
    public function handleThis(AuthenticateUserCommandInterface $authenticateUserCommand): void
    {
        try {
            $username = $authenticateUserCommand->email();

            if ($this->failedAttemptLogger->userExceededTheDailyLimit($username)) {
                throw new TooManyFailedAuthenticationAttemptsException();
            }

            $this->userAuthenticationHandler->handleThis($authenticateUserCommand);
        } catch (Exception $exception) {
            if ($exception instanceof IncorrectPasswordException) {
                $this->failedAttemptLogger->record($authenticateUserCommand->email());
            }
            throw new $exception;
        }
    }

}
