<?php

namespace spec\Github\Domain\Model\Exception;

use Github\Domain\Model\Exception\EmailAlreadyUsedException;
use Github\Shared\Exceptions\ConflictException;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

/**
 * Class EmailAlreadyUsedExceptionSpec
 * @package spec\Github\Domain\Model\Exception
 */
class EmailAlreadyUsedExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(EmailAlreadyUsedException::class);
        $this->shouldHaveType(ConflictException::class);
        $this->shouldHaveType(InvalidArgumentException::class);
    }
}
