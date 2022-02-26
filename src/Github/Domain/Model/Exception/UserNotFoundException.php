<?php

namespace Github\Domain\Model\Exception;

use InvalidArgumentException;

/**
 * Class UserNotFoundException
 * @package Github\Domain\Model\Exception
 */
class UserNotFoundException extends InvalidArgumentException
{
    protected $message = 'Unregistered user.';

    protected $code = 404;
}
