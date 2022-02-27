<?php

namespace spec\Github\Domain\Model\Exception;

use Github\Domain\Model\Exception\PasswordTooShortException;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

/**
 * Class PasswordTooShortExceptionSpec
 * @package spec\Github\Domain\Model\Exception
 */
class PasswordTooShortExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PasswordTooShortException::class);
        $this->shouldHaveType(InvalidArgumentException::class);
    }
}
