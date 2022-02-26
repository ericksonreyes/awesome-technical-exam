<?php

namespace spec\Github\Domain\Model\Exception;

use Github\Domain\Model\Exception\IncorrectPasswordException;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

/**
 * Class IncorrectPasswordExceptionSpec
 * @package spec\Github\Domain\Model\Exception
 */
class IncorrectPasswordExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(IncorrectPasswordException::class);
        $this->shouldHaveType(InvalidArgumentException::class);
    }
}
