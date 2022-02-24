<?php

namespace Github\Domain\Model;

use Github\Domain\Model\Exception\MissingPasswordException;
use Github\Domain\Model\Exception\MissingUsernameException;

/**
 * Class User
 * @package Github\Domain\Model
 */
class User implements UserInterface
{
    /**
     * @var string
     */
    private $id;

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
    private $accountStatus = '';

    /**
     * User constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
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

    /**
     * @return string
     */
    public function accountStatus(): string
    {
        return $this->accountStatus;
    }

    /**
     * @param string $username
     * @param string $password
     */
    public function signUp(string $username, string $password): void
    {
        if (trim($username) === '') {
            throw new MissingUsernameException();
        }

        if (trim($password) === '') {
            throw new MissingPasswordException();
        }

        $this->username = $username;
        $this->password = $password;
        $this->accountStatus = UserInterface::ACCOUNT_STATUS_ACTIVE;
    }
}