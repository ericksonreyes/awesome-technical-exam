<?php

namespace spec\Github\Domain\Model\Exception;

use Github\Domain\Model\Exception\MissingUsernameException;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

class MissingUsernameExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(MissingUsernameException::class);
        $this->shouldHaveType(InvalidArgumentException::class);
    }
}
