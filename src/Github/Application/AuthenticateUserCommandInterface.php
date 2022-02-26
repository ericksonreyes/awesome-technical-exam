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
    public function email(): string;

    /**
     * @return string
     */
    public function password(): string;

}