<?php

namespace Github\Domain\Model\Exception;

use InvalidArgumentException;

/**
 * Class MissingUsernameException
 * @package Github\Domain\Model\Exception
 */
class MissingUsernameException extends InvalidArgumentException
{
    protected $message = 'Username is required.';

    protected $code = 400;
}
