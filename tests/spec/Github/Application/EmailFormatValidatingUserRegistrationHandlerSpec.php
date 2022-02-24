<?php

namespace spec\Github\Application;

use Github\Application\EmailFormatValidatingUserRegistrationHandler;
use Github\Application\PasswordLengthValidatingUserRegistrationHandler;
use Github\Application\RegisterUserCommandInterface;
use Github\Application\UserRegistrationHandlerInterface;
use Github\Domain\Model\Exception\InvalidEmailException;
use PhpSpec\ObjectBehavior;

class EmailFormatValidatingUserRegistrationHandlerSpec extends ObjectBehavior
{

    /**
     * @var UserRegistrationHandlerInterface
     */
    private $userRegistrationHandler;

    public function let(UserRegistrationHandlerInterface $userRegistrationHandler)
    {
        $this->beConstructedWith(
            $this->userRegistrationHandler = $userRegistrationHandler
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(EmailFormatValidatingUserRegistrationHandler::class);
        $this->shouldHaveType(UserRegistrationHandlerInterface::class);
    }

    public function it_validates_email_address_format_and_calls_the_next_handler(
        RegisterUserCommandInterface $registerUserCommand
    ){
        $registerUserCommand->username()->shouldBeCalled()->willReturn('ercbluemonday@yahoo.com');
        $this->userRegistrationHandler->handleThis($registerUserCommand)->shouldBeCalled();

        $this->handleThis($registerUserCommand)->shouldBeNull();
    }

    public function it_rejects_invalid_email_addresses(
        RegisterUserCommandInterface $registerUserCommand
    ) {
        $invalidEmailAddresses = ['', '@email', 'erickson@', 'erickson@mail'];

        foreach ($invalidEmailAddresses as $invalidEmailAddress) {
            $registerUserCommand->username()->shouldBeCalled()->willReturn($invalidEmailAddress);
            $this->userRegistrationHandler->handleThis($registerUserCommand)->shouldNotBeCalled();

            $this->shouldThrow(InvalidEmailException::class)->during(
                'handleThis',
                [
                    $registerUserCommand
                ]
            );
        }
    }
}
