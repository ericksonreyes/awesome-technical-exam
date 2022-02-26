<?php


namespace Github\Application;


interface FailedUserAuthenticationAttemptLoggerInterface
{

    /**
     * @param string $username
     */
    public function record(string $username): void;

    /**
     * @param string $username
     * @return bool
     */
    public function userExceededTheDailyLimit(string $username): bool;

}