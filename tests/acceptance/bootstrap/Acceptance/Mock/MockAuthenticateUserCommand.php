<?php


namespace Acceptance\Mock;


use Github\Application\AuthenticateUserCommandInterface;

/**
 * Class MockAuthenticateUserCommand
 * @package Acceptance\Mock
 */
class MockAuthenticateUserCommand implements AuthenticateUserCommandInterface
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * MockAuthenticateUserCommand constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }


    /**
     * @return string
     */
    public function username(): string
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


}