<?php

namespace spec\Github\Application;

use Github\Application\RegisterUserCommandInterface;
use Github\Application\UserRegistrationHandler;
use Github\Application\UserRegistrationHandlerInterface;
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
        $this->userRepository->store(Argument::type(UserInterface::class))->shouldBeCalled();

        $this->handleThis($command)->shouldBeNull();
    }
}
