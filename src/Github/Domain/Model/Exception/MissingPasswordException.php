<?php

namespace Github\Domain\Model\Exception;

use InvalidArgumentException;

/**
 * Class MissingPasswordException
 * @package Github\Domain\Model\Exception
 */
class MissingPasswordException extends InvalidArgumentException
{
    protected $message = 'Password is required.';

    protected $code = 400;
}
