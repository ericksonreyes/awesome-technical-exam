<?php


namespace Github\Domain\Model;

/**
 * Interface UserInterface
 * @package Github\Domain\Model
 */
interface UserInterface extends UserAttributesInterface
{
    public const ACCOUNT_STATUS_ACTIVE = 'Active';

    /**
     * @param string $username
     * @param string $password
     */
    public function signUp(string $username, string $password): void;
}