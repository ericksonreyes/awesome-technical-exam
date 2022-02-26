<?php

namespace spec\Github\Domain\Model;

use Github\Domain\Model\Exception\MissingEmailException;
use Github\Domain\Model\Exception\MissingPasswordException;
use Github\Domain\Model\Exception\MissingUsernameException;
use Github\Domain\Model\User;
use PhpSpec\ObjectBehavior;

/**
 * Class UserSpec
 * @package spec\Github\Domain\Model
 */
class UserSpec extends ObjectBehavior
{
    /**
     * @var string
     */
    private $id;

    public function let() {
        $this->beConstructedWith(
            $this->id = md5(mt_rand())
        );
    }


    public function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }

    public function it_has_an_identifier()
    {
        $this->id()->shouldBeString();
    }

    public function it_has_an_email()
    {
        $this->email()->shouldBeString();
    }

    public function it_has_a_password()
    {
        $this->password()->shouldBeString();
    }

    public function it_has_an_account_status()
    {
        $this->accountStatus()->shouldBeString();
    }

    public function it_can_sign_up()
    {
        $email = 'erickson@email.com';
        $password = 'SecuredPassword';

        $this->signUp($email, $password)->shouldBeNull();
        $this->email()->shouldReturn($email);
        $this->password()->shouldReturn($password);
        $this->accountStatus()->shouldReturn('Active');
    }

    public function it_requires_a_username_when_signing_up() {
        $emptyEmail = $this->makeEmptyString();
        $password = 'SecuredPassword';

        $this->shouldThrow(MissingEmailException::class)->during(
            'signUp',
            [
                $emptyEmail,
                $password
            ]
        );
    }

    public function it_requires_a_password_when_signing_up() {
        $email = 'erickson@email.com';
        $emptyPassword = $this->makeEmptyString();

        $this->shouldThrow(MissingPasswordException::class)->during(
            'signUp',
            [
                $email,
                $emptyPassword
            ]
        );
    }

    /**
     * @return string
     */
    private function makeEmptyString(): string {
        return str_repeat(' ', mt_rand(0, 5));
    }
}
