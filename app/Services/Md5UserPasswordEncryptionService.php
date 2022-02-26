<?php


namespace App\Services;


use Github\Application\UserPasswordEncryptionServiceInterface;

/**
 * Class Md5UserEncryptionService
 * @package App\Services
 */
class Md5UserPasswordEncryptionService implements UserPasswordEncryptionServiceInterface
{
    /**
     * @param string $password
     * @return string
     */
    public function encrypt(string $password): string
    {
        return md5($password);
    }

}