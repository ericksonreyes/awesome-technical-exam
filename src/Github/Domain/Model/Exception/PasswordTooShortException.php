<?php

namespace Github\Domain\Model\Exception;

use InvalidArgumentException;

/**
 * Class PasswordTooShortException
 * @package Github\Domain\Model\Exception
 */
class PasswordTooShortException extends InvalidArgumentException
{
    protected $message = 'Password is too short.';

    protected $code = 400;
}
