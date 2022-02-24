<?php

namespace Github\Domain\Model\Exception;

use InvalidArgumentException;

/**
 * Class MismatchedPasswordsException
 * @package Github\Domain\Model\Exception
 */
class MismatchedPasswordsException extends InvalidArgumentException
{
    protected $message = 'Passwords does not match.';

    protected $code = 400;
}
