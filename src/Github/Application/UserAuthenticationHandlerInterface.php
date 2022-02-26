<?php


namespace Github\Application;

/**
 * Interface UserAuthenticationHandlerInterface
 * @package Github\Application
 */
interface UserAuthenticationHandlerInterface
{
    /**
     * @param AuthenticateUserCommandInterface $authenticateUserCommand
     */
    public function handleThis(AuthenticateUserCommandInterface $authenticateUserCommand): void;

}
