<?php

namespace spec\Github\Domain\Model;

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
}
