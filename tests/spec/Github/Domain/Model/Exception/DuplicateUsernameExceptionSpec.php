<?php

namespace spec\Github\Domain\Model\Exception;

use Github\Domain\Model\Exception\DuplicateUsernameException;
use Github\Shared\Exceptions\ConflictException;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

/**
 * Class DuplicateUsernameExceptionSpec
 * @package spec\Github\Domain\Model\Exception
 */
class DuplicateUsernameExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(DuplicateUsernameException::class);
        $this->shouldHaveType(ConflictException::class);
        $this->shouldHaveType(InvalidArgumentException::class);
    }
}
