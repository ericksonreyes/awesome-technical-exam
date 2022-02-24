<?php


namespace Github\Application;

/**
 * Interface RegisterUser
 * @package Github\Application
 */
interface RegisterUserCommandInterface
{
    /**
     * @return string
     */
    public function id(): string;

    /**
     * @return string
     */
    public function username(): string;

    /**
     * @return string
     */
    public function password(): string;

    /**
     * @return string
     */
    public function passwordConfirmation(): string;
}