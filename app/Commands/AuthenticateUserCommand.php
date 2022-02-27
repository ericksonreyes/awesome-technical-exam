<?php


namespace App\Commands;


use Github\Application\AuthenticateUserCommandInterface;

/**
 * Class AuthenticateUserCommand
 * @package App\Commands
 */
class AuthenticateUserCommand implements AuthenticateUserCommandInterface
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
     * AuthenticateUserCommand constructor.
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


}