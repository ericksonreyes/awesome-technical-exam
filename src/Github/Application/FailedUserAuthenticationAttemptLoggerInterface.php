<?php


namespace Github\Application;


interface FailedUserAuthenticationAttemptLoggerInterface
{

    /**
     * @param string $email
     */
    public function record(string $email): void;

    /**
     * @param string $username
     * @return bool
     */
    public function userExceededTheDailyLimit(string $username): bool;

}