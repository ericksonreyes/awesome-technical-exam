<?php

namespace Github\Domain\Model\Exception;

use InvalidArgumentException;

/**
 * Class MissingEmailException
 * @package Github\Domain\Model\Exception
 */
class MissingEmailException extends InvalidArgumentException
{
    protected $message = 'E-mail address is required.';

    protected $code = 400;
}
