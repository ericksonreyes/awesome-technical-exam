<?php


namespace App\Services;


use App\Models\FailedUserAuthenticationAttemptModel;
use Exception;
use Github\Application\AuthenticateUserCommandInterface;
use Github\Application\FailedUserAuthenticationAttemptHandlerInterface;
use Github\Domain\Model\Exception\IncorrectPasswordException;

/**
 * Class FailedUserAuthenticationAttemptRecorder
 * @package App\Services
 */
class FailedUserAuthenticationAttemptRecorder implements FailedUserAuthenticationAttemptHandlerInterface
{
    /**
     * @param AuthenticateUserCommandInterface $authenticateUserCommand
     * @param Exception $exceptionRaised
     */
    public function handleThis(
        AuthenticateUserCommandInterface $authenticateUserCommand,
        Exception $exceptionRaised): void
    {
        if ($exceptionRaised instanceof IncorrectPasswordException) {
            $model = new FailedUserAuthenticationAttemptModel();
            $model->username = $authenticateUserCommand->username();
            $model->headers = json_encode(getallheaders());
            $model->save();
        }
    }


}