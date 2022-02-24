<?php

namespace spec\Github\Domain\Model;

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

    public function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }

    public function it_has_a_username()
    {
        $this->username()->shouldBeString();
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
        $username = 'ericksonreyes';
        $password = 'SecuredPassword';

        $this->signUp($username, $password)->shouldBeNull();
        $this->username()->shouldReturn($username);
        $this->password()->shouldReturn($password);
        $this->accountStatus()->shouldReturn('Active');
    }

    public function it_requires_a_username_when_signing_up() {
        $emptyUsername = $this->makeEmptyString();
        $password = 'SecuredPassword';

        $this->shouldThrow(MissingUsernameException::class)->during(
            'signUp',
            [
                $emptyUsername,
                $password
            ]
        );
    }

    public function it_requires_a_password_when_signing_up() {
        $username = 'ericksonreyes';
        $emptyPassword = $this->makeEmptyString();
        $password = 'SecuredPassword';

        $this->shouldThrow(MissingPasswordException::class)->during(
            'signUp',
            [
                $username,
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
