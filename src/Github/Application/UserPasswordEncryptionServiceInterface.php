<?php


namespace Github\Application;

/**
 * Interface UserPasswordEncryptionServiceInterface
 * @package Github\Application
 */
interface UserPasswordEncryptionServiceInterface
{

    /**
     * @param string $password
     * @return string
     */
    public function encrypt(string $password): string;

}