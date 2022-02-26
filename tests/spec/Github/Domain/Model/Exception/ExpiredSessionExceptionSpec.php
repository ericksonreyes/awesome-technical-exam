<?php

namespace spec\Github\Domain\Model\Exception;

use Github\Domain\Model\Exception\ExpiredSessionException;
use Github\Shared\Exceptions\AuthenticationFailureException;
use PhpSpec\ObjectBehavior;

/**
 * Class ExpiredSessionExceptionSpec
 * @package spec\Github\Domain\Model\Exception
 */
class ExpiredSessionExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ExpiredSessionException::class);
        $this->shouldHaveType(AuthenticationFailureException::class);
    }
}
