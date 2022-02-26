<?php


namespace Github\Application;

/**
 * Interface SignInUserCommandInterface
 * @package Github\Application
 */
interface AuthenticateUserCommandInterface
{
    /**
     * @return string
     */
    public function username(): string;

    /**
     * @return string
     */
    public function password(): string;

}