<?php

namespace spec\Github\Domain\Model\Exception;

use Github\Domain\Model\Exception\MissingEmailException;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

/**
 * Class MissingEmailExceptionSpec
 * @package spec\Github\Domain\Model\Exception
 */
class MissingEmailExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(MissingEmailException::class);
        $this->shouldHaveType(InvalidArgumentException::class);
    }
}
