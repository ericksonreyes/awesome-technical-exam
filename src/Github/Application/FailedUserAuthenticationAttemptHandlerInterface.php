<?php


namespace Github\Application;


use Exception;

/**
 * Interface FailedUserAuthenticationHandlerInterface
 * @package Github\Application
 */
interface FailedUserAuthenticationAttemptHandlerInterface
{
    /**
     * @param AuthenticateUserCommandInterface $authenticateUserCommand
     * @param Exception $exceptionRaised
     */
    public function handleThis(
        AuthenticateUserCommandInterface $authenticateUserCommand,
        Exception $exceptionRaised
    ): void;
}