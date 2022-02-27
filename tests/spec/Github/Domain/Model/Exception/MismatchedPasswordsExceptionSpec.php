<?php

namespace spec\Github\Domain\Model\Exception;

use Github\Domain\Model\Exception\MismatchedPasswordsException;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

/**
 * Class MismatchedPasswordsExceptionSpec
 * @package spec\Github\Domain\Model\Exception
 */
class MismatchedPasswordsExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(MismatchedPasswordsException::class);
        $this->shouldHaveType(InvalidArgumentException::class);
    }
}
