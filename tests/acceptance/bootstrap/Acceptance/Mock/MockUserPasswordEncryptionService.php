<?php


namespace Acceptance\Mock;


use Github\Application\UserPasswordEncryptionServiceInterface;

/**
 * Class MockUserPasswordEncryptionService
 * @package Acceptance\Mock
 */
class MockUserPasswordEncryptionService implements UserPasswordEncryptionServiceInterface
{
    /**
     * @param string $password
     * @return string
     */
    public function encrypt(string $password): string
    {
        return 'encrypted-' . $password;
    }


}