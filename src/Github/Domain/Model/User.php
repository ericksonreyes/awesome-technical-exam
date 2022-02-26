<?php

namespace Github\Domain\Model;

use Github\Domain\Model\Exception\MissingEmailException;
use Github\Domain\Model\Exception\MissingPasswordException;

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
    private $email = '';

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
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
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
     * @param string $email
     * @param string $password
     */
    public function signUp(string $email, string $password): void
    {
        if (trim($email) === '') {
            throw new MissingEmailException();
        }

        if (trim($password) === '') {
            throw new MissingPasswordException();
        }

        $this->email = $email;
        $this->password = $password;
        $this->accountStatus = UserInterface::ACCOUNT_STATUS_ACTIVE;
    }
}
