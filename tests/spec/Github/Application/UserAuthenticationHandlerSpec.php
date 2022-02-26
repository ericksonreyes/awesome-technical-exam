<?php

namespace spec\Github\Application;

use Github\Application\AuthenticateUserCommandInterface;
use Github\Application\UserAuthenticationHandler;
use Github\Application\UserAuthenticationHandlerInterface;
use Github\Domain\Model\Exception\IncorrectPasswordException;
use Github\Domain\Model\Exception\UserNotFoundException;
use Github\Domain\Model\UserInterface;
use Github\Domain\Repository\UserRepository;
use PhpSpec\ObjectBehavior;

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
}
