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
     * @param string $email
     * @param string $password
     */
    public function signUp(string $email, string $password): void;
}