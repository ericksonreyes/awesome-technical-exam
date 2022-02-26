<?php

namespace spec\Github\Application;

use Github\Application\RegisterUserCommandInterface;
use Github\Application\UserPasswordEncryptionServiceInterface;
use Github\Application\UserRegistrationHandler;
use Github\Application\UserRegistrationHandlerInterface;
use Github\Domain\Model\Exception\EmailAlreadyUsedException;
use Github\Domain\Model\Exception\MismatchedPasswordsException;
use Github\Domain\Model\Exception\MissingEmailException;
use Github\Domain\Model\Exception\MissingPasswordException;
use Github\Domain\Model\Exception\MissingUsernameException;
use Github\Domain\Model\UserInterface;
use Github\Domain\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class UserRegistrationHandlerSpec
 * @package spec\Github\Application
 */
class UserRegistrationHandlerSpec extends ObjectBehavior
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserPasswordEncryptionServiceInterface
     */
    protected $passwordEncryptionService;

    public function let(
        UserRepository $userRepository,
        UserPasswordEncryptionServiceInterface $passwordEncryptionService
    )
    {
        $this->beConstructedWith(
            $this->userRepository = $userRepository,
            $this->passwordEncryptionService = $passwordEncryptionService
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UserRegistrationHandler::class);
        $this->shouldHaveType(UserRegistrationHandlerInterface::class);
    }

    public function it_handles_register_user_commands(RegisterUserCommandInterface $command)
    {
        $command->id()->shouldBeCalled()->willReturn('user-1');
        $command->email()->shouldBeCalled()->willReturn('erickson@reyes.com');
        $command->password()->shouldBeCalled()->willReturn('SecuredPassword');
        $command->passwordConfirmation()->shouldBeCalled()->willReturn('SecuredPassword');

        $this->userRepository->findOneByUsername('erickson@reyes.com')
            ->shouldBeCalled()
            ->willReturn(null);
        $this->userRepository->store(Argument::type(UserInterface::class))->shouldBeCalled();
        $this->passwordEncryptionService->encrypt('SecuredPassword')
            ->shouldBeCalled()
            ->willReturn('EncryptedSecuredPassword');

        $this->handleThis($command)->shouldBeNull();
    }

    public function it_requires_an_email(RegisterUserCommandInterface $command)
    {
        $command->id()->shouldBeCalled()->willReturn('user-1');
        $command->password()->shouldBeCalled()->willReturn('SecuredPassword');
        $command->passwordConfirmation()->shouldBeCalled()->willReturn('SecuredPassword');

        $emptyUserNames = ['', ' ', '     '];
        foreach ($emptyUserNames as $emptyUserName) {
            $command->email()->shouldBeCalled()->willReturn($emptyUserName);
            $this->shouldThrow(MissingEmailException::class)->during(
                'handleThis',
                [
                    $command
                ]
            );
        }
    }

    public function it_requires_a_password(RegisterUserCommandInterface $command)
    {
        $command->id()->shouldBeCalled()->willReturn('user-1');
        $command->email()->shouldBeCalled()->willReturn('erickson@reyes.com');
        $command->passwordConfirmation()->shouldBeCalled()->willReturn('SecuredPassword');

        $emptyPasswords = ['', ' ', '     '];
        foreach ($emptyPasswords as $emptyPassword) {
            $command->password()->shouldBeCalled()->willReturn($emptyPassword);
            $this->shouldThrow(MissingPasswordException::class)->during(
                'handleThis',
                [
                    $command
                ]
            );
        }
    }

    public function it_requires_a_unique_email(RegisterUserCommandInterface $command, UserInterface $anExistingUser)
    {
        $command->id()->shouldBeCalled()->willReturn('user-1');
        $command->email()->shouldBeCalled()->willReturn('erickson@reyes.com');
        $command->password()->shouldBeCalled()->willReturn('SecuredPassword');
        $command->passwordConfirmation()->shouldBeCalled()->willReturn('SecuredPassword');

        $this->userRepository->findOneByUsername('erickson@reyes.com')
            ->shouldBeCalled()
            ->willReturn($anExistingUser);

        $this->shouldThrow(EmailAlreadyUsedException::class)->during(
            'handleThis',
            [
                $command
            ]
        );
    }

    public function it_requires_that_the_passwords_matches(RegisterUserCommandInterface $command)
    {
        $command->id()->shouldBeCalled()->willReturn('user-1');
        $command->email()->shouldBeCalled()->willReturn('erickson@reyes.com');
        $command->password()->shouldBeCalled()->willReturn('SecuredPassword');
        $command->passwordConfirmation()->shouldBeCalled()->willReturn('ADifferentPassword');

        $this->shouldThrow(MismatchedPasswordsException::class)->during(
            'handleThis',
            [
                $command
            ]
        );
    }
}
