<?php

namespace Github\Domain\Model\Exception;

use InvalidArgumentException;

/**
 * Class IncorrectPasswordException
 * @package Github\Domain\Model\Exception
 */
class IncorrectPasswordException extends InvalidArgumentException
{
    protected $message = 'Incorrect password.';

    protected $code = 400;
}
