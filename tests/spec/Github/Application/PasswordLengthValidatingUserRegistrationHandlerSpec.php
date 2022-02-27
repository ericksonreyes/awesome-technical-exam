<?php

namespace spec\Github\Application;

use Github\Application\PasswordLengthValidatingUserRegistrationHandler;
use Github\Application\RegisterUserCommandInterface;
use Github\Application\UserRegistrationHandlerInterface;
use Github\Domain\Model\Exception\PasswordTooShortException;
use PhpSpec\ObjectBehavior;

/**
 * Class PasswordLengthValidatingUserRegistrationHandlerSpec
 * @package spec\Github\Application
 */
class PasswordLengthValidatingUserRegistrationHandlerSpec extends ObjectBehavior
{

    /**
     * @var UserRegistrationHandlerInterface
     */
    private $userRegistrationHandler;

    /**
     * @var int
     */
    private $requiredMinimumPasswordLength;

    public function let(UserRegistrationHandlerInterface $userRegistrationHandler)
    {
        $this->beConstructedWith(
            $this->userRegistrationHandler = $userRegistrationHandler,
            $this->requiredMinimumPasswordLength = mt_rand(5, 10)
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PasswordLengthValidatingUserRegistrationHandler::class);
        $this->shouldHaveType(UserRegistrationHandlerInterface::class);
    }

    public function it_validates_password_length_and_calls_the_next_registration_handler(
        RegisterUserCommandInterface $registerUserCommand
    )
    {
        $generatedPassword = md5(time());
        $passwordLength = mt_rand($this->requiredMinimumPasswordLength, $this->requiredMinimumPasswordLength + 10);
        $password = substr($generatedPassword, 0, $passwordLength);

        $registerUserCommand->password()
            ->shouldBeCalled()
            ->willReturn($password);
        $this->userRegistrationHandler->handleThis($registerUserCommand)
            ->shouldBeCalled();

        $this->handleThis($registerUserCommand)->shouldBeNull();
    }

    public function it_rejects_short_passwords(RegisterUserCommandInterface $registerUserCommand)
    {
        $generatedPassword = md5(time());
        $passwordLength = mt_rand(1, $this->requiredMinimumPasswordLength - 1);
        $password = substr($generatedPassword, 0, $passwordLength);

        $registerUserCommand->password()
            ->shouldBeCalled()
            ->willReturn($password);
        $this->userRegistrationHandler->handleThis($registerUserCommand)
            ->shouldNotBeCalled();

        $this->shouldThrow(PasswordTooShortException::class)->during(
            'handleThis',
            [
                $registerUserCommand
            ]
        );
    }


}
