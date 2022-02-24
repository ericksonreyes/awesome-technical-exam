<?php

namespace Github\Domain\Model\Exception;

use Github\Shared\Exception\ConflictException;

/**
 * Class DuplicateUsernameException
 * @package Github\Domain\Model\Exception
 */
class DuplicateUsernameException extends ConflictException
{
    protected $message = 'Username already in use.';
}
