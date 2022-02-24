<?php


namespace Github\Application;

/**
 * Interface UserRegistrationHandlerInterface
 * @package Github\Application
 */
interface UserRegistrationHandlerInterface
{

    /**
     * @param RegisterUserCommandInterface $registerUserCommand
     */
    public function handleThis(RegisterUserCommandInterface $registerUserCommand): void;

}