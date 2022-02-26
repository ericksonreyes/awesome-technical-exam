<?php


namespace Github\Application;

/**
 * Interface UserAuthenticationHandlerInterface
 * @package Github\Application
 */
interface UserAuthenticationHandlerInterface
{
    const DEFAULT_MAXIMUM_NUMBER_OF_FAILED_ATTEMPTS_IN_A_DAY = 3;

    /**
     * @param AuthenticateUserCommandInterface $authenticateUserCommand
     */
    public function handleThis(AuthenticateUserCommandInterface $authenticateUserCommand): void;

}
