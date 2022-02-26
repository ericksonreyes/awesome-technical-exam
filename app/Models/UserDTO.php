<?php


namespace App\Models;


use Github\Domain\Model\UserAttributesInterface;
use Github\Domain\Model\UserInterface;

/**
 * Class UserDTO
 * @package App\Models
 */
class UserDTO implements UserAttributesInterface
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
    private $accountStatus;

    /**
     * @param string $id
     * @return UserDTO
     */
    public function setId(string $id): UserDTO
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $username
     * @return UserDTO
     */
    public function setUsername(string $username): UserDTO
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @param string $password
     * @return UserDTO
     */
    public function setPassword(string $password): UserDTO
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param string $accountStatus
     * @return UserDTO
     */
    public function setAccountStatus(string $accountStatus): UserDTO
    {
        $this->accountStatus = $accountStatus;
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
    public function accountStatus(): string
    {
        return $this->accountStatus;
    }

}