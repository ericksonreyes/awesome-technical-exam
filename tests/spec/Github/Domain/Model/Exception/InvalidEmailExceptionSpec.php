<?php

namespace spec\Github\Domain\Model\Exception;

use Github\Domain\Model\Exception\InvalidEmailException;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

/**
 * Class InvalidEmailExceptionSpec
 * @package spec\Github\Domain\Model\Exception
 */
class InvalidEmailExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(InvalidEmailException::class);
        $this->shouldHaveType(InvalidArgumentException::class);
    }
}
