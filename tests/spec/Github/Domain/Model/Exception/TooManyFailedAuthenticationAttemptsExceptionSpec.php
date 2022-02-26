<?php

namespace spec\Github\Domain\Model\Exception;

use Github\Domain\Model\Exception\TooManyFailedAuthenticationAttemptsException;
use PhpSpec\ObjectBehavior;

class TooManyFailedAuthenticationAttemptsExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TooManyFailedAuthenticationAttemptsException::class);
    }
}
