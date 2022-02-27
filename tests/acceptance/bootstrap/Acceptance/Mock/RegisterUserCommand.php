<?php


namespace Acceptance\Mock;


use Github\Application\RegisterUserCommandInterface;

/**
 * Class RegisterUserCommand
 * @package Acceptance\Mock
 */
class RegisterUserCommand implements RegisterUserCommandInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $passwordConfirmation;

    /**
     * @param string $id
     * @return RegisterUserCommand
     */
    public function setId(string $id): RegisterUserCommand
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $username
     * @return RegisterUserCommand
     */
    public function setUsername(string $username): RegisterUserCommand
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @param string $password
     * @return RegisterUserCommand
     */
    public function setPassword(string $password): RegisterUserCommand
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param string $passwordConfirmation
     * @return RegisterUserCommand
     */
    public function setPasswordConfirmation(string $passwordConfirmation): RegisterUserCommand
    {
        $this->passwordConfirmation = $passwordConfirmation;
        return $this;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function passwordConfirmation(): string
    {
        return $this->passwordConfirmation;
    }
}