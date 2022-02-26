<?php

namespace spec\Github\Application;

use Github\Application\AuthenticateUserCommandInterface;
use Github\Application\UserAuthenticationHandler;
use Github\Application\UserAuthenticationHandlerInterface;
use Github\Application\UserPasswordEncryptionServiceInterface;
use Github\Domain\Model\Exception\IncorrectPasswordException;
use Github\Domain\Model\Exception\MissingEmailException;
use Github\Domain\Model\Exception\MissingPasswordException;
use Github\Domain\Model\Exception\MissingUsernameException;
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

    /**
     * @var UserPasswordEncryptionServiceInterface
     */
    private $passwordEncryptionService;

    public function let(
        UserRepository $userRepository,
        UserPasswordEncryptionServiceInterface $passwordEncryptionService
    ) {
        $this->beConstructedWith(
            $this->userRepository = $userRepository,
            $this->passwordEncryptionService = $passwordEncryptionService
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
        $email = 'erickson@reyes.com';
        $password = 'SecuredPassword';
        $encryptedPassword = 'EncryptedPassword';

        $authenticateUserCommand->email()->shouldBeCalled()->willReturn($email);
        $authenticateUserCommand->password()->shouldBeCalled()->willReturn($password);
        $anExistingUser->password()->shouldBeCalled()->willReturn($encryptedPassword);

        $this->passwordEncryptionService->encrypt($password)->shouldBeCalled()->willReturn($encryptedPassword);
        $this->userRepository->findOneByEmail($email)->shouldBeCalled()->willReturn($anExistingUser);
        $this->handleThis($authenticateUserCommand)->shouldBeNull();
    }

    public function it_requires_a_username(AuthenticateUserCommandInterface $authenticateUserCommand) {
        $emptyUserNames = ['', ' ', '     '];
        $password = 'SecuredPassword';

        foreach ($emptyUserNames as $emptyUsername) {
            $authenticateUserCommand->email()->shouldBeCalled()->willReturn($emptyUsername);
            $authenticateUserCommand->password()->shouldBeCalled()->willReturn($password);
            $this->shouldThrow(MissingEmailException::class)->during(
                'handleThis',
                [
                    $authenticateUserCommand
                ]
            );
        }
    }

    public function it_requires_a_password(AuthenticateUserCommandInterface $authenticateUserCommand) {
        $email = 'erickson@reyes.com';
        $emptyPasswords = ['', ' ', '     '];

        foreach ($emptyPasswords as $emptyPassword) {
            $authenticateUserCommand->email()->shouldBeCalled()->willReturn($email);
            $authenticateUserCommand->password()->shouldBeCalled()->willReturn($emptyPassword);
            $this->shouldThrow(MissingPasswordException::class)->during(
                'handleThis',
                [
                    $authenticateUserCommand
                ]
            );
        }
    }

    public function it_rejects_incorrect_passwords(
        AuthenticateUserCommandInterface $authenticateUserCommand,
        UserInterface $anExistingUser
    )
    {
        $email = 'erickson@reyes.com';
        $password = 'SecuredPassword';
        $encryptedPassword = 'EncryptedPassword';
        $encryptedIncorrectPassword = 'EncryptedIncorrectPassword';

        $authenticateUserCommand->email()->shouldBeCalled()->willReturn($email);
        $authenticateUserCommand->password()->shouldBeCalled()->willReturn($password);
        $anExistingUser->password()->shouldBeCalled()->willReturn($encryptedPassword);

        $this->userRepository->findOneByEmail($email)->shouldBeCalled()->willReturn($anExistingUser);
        $this->passwordEncryptionService->encrypt($password)->shouldBeCalled()->willReturn($encryptedIncorrectPassword);
        $this->shouldThrow(IncorrectPasswordException::class)->during(
            'handleThis',
            [
                $authenticateUserCommand
            ]
        );
    }

    public function it_rejects_unregistered_users(AuthenticateUserCommandInterface $authenticateUserCommand)
    {
        $email = 'erickson@reyes.com';
        $password = 'SecuredPassword';

        $authenticateUserCommand->email()->shouldBeCalled()->willReturn($email);
        $authenticateUserCommand->password()->shouldBeCalled()->willReturn($password);

        $this->userRepository->findOneByEmail($email)->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(UserNotFoundException::class)->during(
            'handleThis',
            [
                $authenticateUserCommand
            ]
        );
    }
}
