<?php

namespace spec\Github\Application;

use Exception;
use Github\Application\AuthenticateUserCommandInterface;
use Github\Application\FailedUserAuthenticationAttemptHandlerInterface;
use Github\Application\UserAuthenticationHandler;
use Github\Application\UserAuthenticationHandlerInterface;
use Github\Domain\Model\Exception\IncorrectPasswordException;
use Github\Domain\Model\Exception\UserNotFoundException;
use Github\Domain\Model\UserInterface;
use Github\Domain\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class UserAuthenticationHandlerSpec
 * @package spec\Github\Application
 */
class UserAuthenticationHandlerSpec extends ObjectBehavior
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function let(UserRepository $userRepository)
    {
        $this->beConstructedWith(
            $this->userRepository = $userRepository
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UserAuthenticationHandler::class);
        $this->shouldHaveType(UserAuthenticationHandlerInterface::class);
    }

    public function it_handles_user_authentication_commands(
        AuthenticateUserCommandInterface $authenticateUserCommand,
        UserInterface $anExistingUser
    )
    {
        $username = 'erickson';
        $password = 'SecuredPassword';

        $authenticateUserCommand->username()->shouldBeCalled()->willReturn($username);
        $authenticateUserCommand->password()->shouldBeCalled()->willReturn($password);
        $anExistingUser->password()->shouldBeCalled()->willReturn($password);

        $this->userRepository->findOneByUsername($username)->shouldBeCalled()->willReturn($anExistingUser);

        $this->handleThis($authenticateUserCommand)->shouldBeNull();
    }

    public function it_rejects_incorrect_passwords(
        AuthenticateUserCommandInterface $authenticateUserCommand,
        UserInterface $anExistingUser
    )
    {
        $username = 'erickson';
        $password = 'SecuredPassword';
        $incorrectPassword = 'IncorrectPassword';

        $authenticateUserCommand->username()->shouldBeCalled()->willReturn($username);
        $authenticateUserCommand->password()->shouldBeCalled()->willReturn($incorrectPassword);
        $anExistingUser->password()->shouldBeCalled()->willReturn($password);

        $this->userRepository->findOneByUsername($username)->shouldBeCalled()->willReturn($anExistingUser);

        $this->shouldThrow(IncorrectPasswordException::class)->during(
            'handleThis',
            [
                $authenticateUserCommand
            ]
        );
    }

    public function it_rejects_unregistered_users(AuthenticateUserCommandInterface $authenticateUserCommand)
    {
        $username = 'erickson';
        $password = 'SecuredPassword';

        $authenticateUserCommand->username()->shouldBeCalled()->willReturn($username);
        $authenticateUserCommand->password()->shouldBeCalled()->willReturn($password);

        $this->userRepository->findOneByUsername($username)->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(UserNotFoundException::class)->during(
            'handleThis',
            [
                $authenticateUserCommand
            ]
        );
    }

    public function it_can_have_successful_authentication_handlers(
        UserAuthenticationHandlerInterface $successfulAuthenticationHandler
    )
    {
        $this->registerSuccessfulAuthenticationHandler($successfulAuthenticationHandler)->shouldBeNull();
    }

    public function it_can_have_failed_authentication_attempt_handlers(
        FailedUserAuthenticationAttemptHandlerInterface $failedUserAuthenticationAttemptHandler
    )
    {
        $this->registerFailedAuthenticationAttemptHandler($failedUserAuthenticationAttemptHandler)->shouldBeNull();
    }

    public function it_calls_registered_successful_authentication_handlers(
        AuthenticateUserCommandInterface $authenticateUserCommand,
        UserInterface $anExistingUser,
        UserAuthenticationHandlerInterface $successfulAuthenticationHandler,
        UserAuthenticationHandlerInterface $anotherSuccessfulAuthenticationHandler,
        UserAuthenticationHandlerInterface $andAnotherSuccessfulAuthenticationHandler
    )
    {
        $username = 'erickson';
        $password = 'SecuredPassword';

        $authenticateUserCommand->username()->shouldBeCalled()->willReturn($username);
        $authenticateUserCommand->password()->shouldBeCalled()->willReturn($password);
        $anExistingUser->password()->shouldBeCalled()->willReturn($password);

        $this->userRepository->findOneByUsername($username)->shouldBeCalled()->willReturn($anExistingUser);
        $successfulAuthenticationHandler->handleThis($authenticateUserCommand)->shouldBeCalledTimes(1);
        $anotherSuccessfulAuthenticationHandler->handleThis($authenticateUserCommand)->shouldBeCalledTimes(1);

        $this->registerSuccessfulAuthenticationHandler($successfulAuthenticationHandler)->shouldBeNull();
        $this->registerSuccessfulAuthenticationHandler($anotherSuccessfulAuthenticationHandler)->shouldBeNull();
        $this->registerSuccessfulAuthenticationHandler($andAnotherSuccessfulAuthenticationHandler)->shouldBeNull();

        $this->handleThis($authenticateUserCommand);
    }

    public function it_calls_registered_failed_authentication_attempt_handlers(
        AuthenticateUserCommandInterface $authenticateUserCommand,
        UserInterface $anExistingUser,
        FailedUserAuthenticationAttemptHandlerInterface $successfulFailedAuthenticationHandler,
        FailedUserAuthenticationAttemptHandlerInterface $anotherFailedAuthenticationHandler
    )
    {
        $username = 'erickson';
        $password = 'SecuredPassword';
        $incorrectPassword = 'IncorrectPassword';

        $authenticateUserCommand->username()->shouldBeCalled()->willReturn($username);
        $authenticateUserCommand->password()->shouldBeCalled()->willReturn($incorrectPassword);
        $anExistingUser->password()->shouldBeCalled()->willReturn($password);

        $this->userRepository->findOneByUsername($username)->shouldBeCalled()->willReturn($anExistingUser);
        $successfulFailedAuthenticationHandler->handleThis(
            $authenticateUserCommand,
            Argument::type(Exception::class)
        )->shouldBeCalledTimes(1);
        $anotherFailedAuthenticationHandler->handleThis(
            $authenticateUserCommand,
            Argument::type(Exception::class)
        )->shouldBeCalledTimes(1);

        $this->registerFailedAuthenticationAttemptHandler($successfulFailedAuthenticationHandler)->shouldBeNull();
        $this->registerFailedAuthenticationAttemptHandler($anotherFailedAuthenticationHandler)->shouldBeNull();

        $this->shouldThrow(Exception::class)->during(
            'handleThis',
            [
                $authenticateUserCommand
            ]
        );
    }

}
