<?php


namespace App\Commands;


use Github\Application\RegisterUserCommandInterface;

/**
 * Class RegisterUser
 * @package App\Commands
 */
class RegisterUser implements RegisterUserCommandInterface
{
    /**
     * @var string
     */
    private $id = '';

    /**
     * @var string
     */
    private $username = '';

    /**
     * @var string
     */
    private $password = '';

    /**
     * @var string
     */
    private $passwordConfirmation = '';

    /**
     * RegisterUser constructor.
     * @param string $id
     * @param string $username
     * @param string $password
     */
    public function __construct(string $id, string $username, string $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param string $passwordConfirmation
     * @return RegisterUser
     */
    public function withPasswordConfirmation(string $passwordConfirmation): RegisterUser
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