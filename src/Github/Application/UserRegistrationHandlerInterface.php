<?php


namespace Github\Application;

/**
 * Interface UserRegistrationHandlerInterface
 * @package Github\Application
 */
interface UserRegistrationHandlerInterface
{

    /**
     * @param RegisterUserCommandInterface $command
     */
    public function handleThis(RegisterUserCommandInterface $command): void;

}