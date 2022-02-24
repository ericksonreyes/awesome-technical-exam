<?php

namespace spec\Github\Domain\Model\Exception;

use Github\Domain\Model\Exception\MissingPasswordException;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

/**
 * Class MissingPasswordExceptionSpec
 * @package spec\Github\Domain\Model\Exception
 */
class MissingPasswordExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(MissingPasswordException::class);
        $this->shouldHaveType(InvalidArgumentException::class);
    }
}
