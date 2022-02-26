<?php


namespace Acceptance\Mock;


use Github\Application\FailedUserAuthenticationAttemptLoggerInterface;

/**
 * Class MockFailedUserAuthenticationLogger
 * @package Acceptance\Mock
 */
class MockFailedUserAuthenticationLogger implements FailedUserAuthenticationAttemptLoggerInterface
{
    /**
     * @var array
     */
    private $failedAttempts = [];

    /**
     * @var int
     */
    private $allowedAttempts = 0;

    /**
     * MockFailedUserAuthenticationLogger constructor.
     * @param int $allowedAttempts
     */
    public function __construct(int $allowedAttempts)
    {
        $this->allowedAttempts = $allowedAttempts;
    }


    /**
     * @param string $username
     */
    public function record(string $username): void
    {
        if (array_key_exists($username, $this->failedAttempts) === false) {
            $this->failedAttempts[$username] = 0;
        }
        $this->failedAttempts[$username]++;
    }

    /**
     * @param string $username
     * @return bool
     */
    public function userExceededTheDailyLimit(string $username): bool
    {
        if (array_key_exists($username, $this->failedAttempts) === false) {
            return false;
        }
        $failedAttempts = $this->failedAttempts[$username];

        return $failedAttempts > $this->allowedAttempts;

    }

}