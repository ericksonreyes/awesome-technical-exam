<?php

namespace spec\Github\Domain\Model\Exception;

use Github\Domain\Model\Exception\UserNotFoundException;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

/**
 * Class UserNotFoundExceptionSpec
 * @package spec\Github\Domain\Model\Exception
 */
class UserNotFoundExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(UserNotFoundException::class);
        $this->shouldHaveType(InvalidArgumentException::class);
    }
}
