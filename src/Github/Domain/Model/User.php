<?php

namespace Github\Domain\Model;

/**
 * Class User
 * @package Github\Domain\Model
 */
class User
{
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
        $this->username = $username;
        $this->password = $password;
        $this->accountStatus = UserInterface::ACCOUNT_STATUS_ACTIVE;
    }
}
