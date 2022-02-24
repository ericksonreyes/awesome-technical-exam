<?php


namespace Github\Domain\Model;

/**
 * Interface UserInterface
 * @package Github\Domain\Model
 */
interface UserInterface
{
    public const ACCOUNT_STATUS_ACTIVE = 'Active';

    /**
     * @return string
     */
    public function username(): string;

    /**
     * @return string
     */
    public function password(): string;

    /**
     * @return string
     */
    public function accountStatus(): string;

    /**
     * @param string $username
     * @param string $password
     */
    public function signUp(string $username, string $password): void;
}