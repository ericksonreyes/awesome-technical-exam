<?php

namespace spec\Github\Application;

use Github\Application\EmailFormatValidatingUserRegistrationHandler;
use Github\Application\PasswordLengthValidatingUserRegistrationHandler;
use Github\Application\RegisterUserCommandInterface;
use Github\Application\UserRegistrationHandlerInterface;
use Github\Domain\Model\Exception\InvalidEmailException;
use Github\Domain\Model\Exception\MissingEmailException;
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

    public function it_rejects_empty_email_addresses(
        RegisterUserCommandInterface $registerUserCommand
    ) {
        $emptyEmailAddress = str_repeat(' ', mt_rand(0, 5));
        $registerUserCommand->username()->shouldBeCalled()->willReturn($emptyEmailAddress);

        $this->userRegistrationHandler->handleThis($registerUserCommand)->shouldNotBeCalled();

        $this->shouldThrow(MissingEmailException::class)->during(
            'handleThis',
            [
                $registerUserCommand
            ]
        );
    }

    public function it_rejects_invalid_email_addresses(
        RegisterUserCommandInterface $registerUserCommand
    ) {
        $invalidEmailAddresses = ['@email', 'erickson@', 'erickson@mail'];

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
