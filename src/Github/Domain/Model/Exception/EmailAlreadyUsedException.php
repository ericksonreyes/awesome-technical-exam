<?php

namespace Github\Domain\Model\Exception;

use Github\Shared\Exceptions\ConflictException;

/**
 * Class EmailAlreadyUsedException
 * @package Github\Domain\Model\Exception
 */
class EmailAlreadyUsedException extends ConflictException
{
    protected $message = 'E-mail already in use.';
}
