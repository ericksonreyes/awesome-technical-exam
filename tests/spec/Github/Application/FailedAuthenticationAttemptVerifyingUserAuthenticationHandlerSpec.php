<?php

namespace spec\Github\Application;

use Github\Application\AuthenticateUserCommandInterface;
use Github\Application\FailedAuthenticationAttemptVerifyingUserAuthenticationHandler;
use Github\Application\FailedUserAuthenticationAttemptLoggerInterface;
use Github\Application\UserAuthenticationHandlerInterface;
use Github\Domain\Model\Exception\IncorrectPasswordException;
use Github\Domain\Model\Exception\TooManyFailedAuthenticationAttemptsException;
use PhpSpec\ObjectBehavior;

/**
 * Class BlacklistVerifyingUserAuthenticationHandlerSpec
 * @package spec\Github\Application
 */
class FailedAuthenticationAttemptVerifyingUserAuthenticationHandlerSpec extends ObjectBehavior
{

    /**
     * @var UserAuthenticationHandlerInterface
     */
    private $userAuthenticationHandler;

    /**
     * @var FailedUserAuthenticationAttemptLoggerInterface
     */
    private $failedAttemptLogger;

    /**
     * @var int
     */
    private $maximumNumberOfFailedAttempts = 3;

    public function let(
        UserAuthenticationHandlerInterface $userAuthenticationHandler,
        FailedUserAuthenticationAttemptLoggerInterface $failedAttemptLogger
    )
    {
        $this->beConstructedWith(
            $this->userAuthenticationHandler = $userAuthenticationHandler,
            $this->failedAttemptLogger = $failedAttemptLogger,
            $this->maximumNumberOfFailedAttempts
        );
    }


    public function it_is_initializable()
    {
        $this->shouldHaveType(FailedAuthenticationAttemptVerifyingUserAuthenticationHandler::class);
        $this->shouldHaveType(UserAuthenticationHandlerInterface::class);
    }

    public function it_records_failed_user_authentication_attempts(
        AuthenticateUserCommandInterface $authenticateUserCommand
    )
    {
        $authenticateUserCommand->username()->shouldBeCalled()->willReturn('erickson');
        $this->failedAttemptLogger->userExceededTheDailyLimit('erickson')->shouldBeCalled()->willReturn(false);
        $this->failedAttemptLogger->record('erickson')->shouldBeCalledTimes(1);
        $this->userAuthenticationHandler->handleThis($authenticateUserCommand)
            ->shouldBeCalledTimes(1)->willThrow(IncorrectPasswordException::class);

        $this->shouldThrow(IncorrectPasswordException::class)->during(
            'handleThis',
            [
                $authenticateUserCommand
            ]
        );
    }

    public function it_prevents_excessive_user_authentication_attempts(
        AuthenticateUserCommandInterface $authenticateUserCommand
    )
    {
        $authenticateUserCommand->username()->shouldBeCalled()->willReturn('erickson');
        $this->failedAttemptLogger->userExceededTheDailyLimit('erickson')->shouldBeCalled()->willReturn(true);

        $this->shouldThrow(TooManyFailedAuthenticationAttemptsException::class)->during(
            'handleThis',
            [
                $authenticateUserCommand
            ]
        );
    }
}
