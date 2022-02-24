<?php

namespace spec\Github\Application;

use Github\Application\RegisterUserCommandInterface;
use Github\Application\UserRegistrationHandler;
use Github\Application\UserRegistrationHandlerInterface;
use Github\Domain\Model\Exception\MismatchedPasswordsException;
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

    public function let(UserRepository $userRepository)
    {
        $this->beConstructedWith(
            $this->userRepository = $userRepository
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
        $command->username()->shouldBeCalled()->willReturn('ericksonreyes');
        $command->password()->shouldBeCalled()->willReturn('SecuredPassword');
        $command->passwordConfirmation()->shouldBeCalled()->willReturn('SecuredPassword');

        $this->userRepository->store(Argument::type(UserInterface::class))->shouldBeCalled();

        $this->handleThis($command)->shouldBeNull();
    }

    public function it_requires_that_the_passwords_matches(RegisterUserCommandInterface $command)
    {
        $command->id()->shouldBeCalled()->willReturn('user-1');
        $command->username()->shouldBeCalled()->willReturn('ericksonreyes');
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
